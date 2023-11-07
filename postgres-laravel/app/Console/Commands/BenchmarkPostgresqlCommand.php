<?php

namespace App\Console\Commands;

use App\Models\Skill;
use App\Models\Skilltree;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;

class BenchmarkPostgresqlCommand extends Command
{
    private const MEMORY_STREAM_20MB = 20971520;
    private const CSV_SEPARATOR = ';';

    protected $signature = 'app:benchmark-postgresql {skills-depth} {benchmark-count} {sleep-after-query}';

    protected $description = '';

    private FilesystemManager $filesystemManager;

    private array $benchmarkResults = [];

    public function handle(FilesystemManager $filesystemManager): int
    {
//        $skilltree = Skilltree::first();
//
//        dump($this->benchmarkQuery($skilltree));
//
//
//        return 0;
        $this->filesystemManager = $filesystemManager;

        $this->info('Refreshing database');
        Artisan::call('migrate:fresh');

        $skillsDepth = (int)$this->argument('skills-depth');
        $benchmarkCount = (int)$this->argument('benchmark-count');
        $sleepAfterQuery = (int)$this->argument('sleep-after-query');

        $this->info('Starting benchmarks:');
        $this->info('Skills depth: ' . $skillsDepth);

        $skilltree = Skilltree::factory()->create();
        $skill = Skill::factory()->create([
            'skilltree_id' => $skilltree->id,
        ]);

        $numberOfChildSkills = 1;
        $deepestSkill = $skill;

        do {
            $numberOfBenchmarks = 0;

            $benchmarks = [];
            while ($numberOfBenchmarks < $benchmarkCount) {
                try {
                    $benchmarks[] = $s = $this->benchmarkQuery($skilltree) * 1000;
                    $this->info('Time: ' . $s . 'ms');
                    usleep($sleepAfterQuery);

                } catch (Exception $e) {
                    $this->error($e->getMessage());
                } finally {
                    $numberOfBenchmarks++;
                }
            }

            try {
                $deepestSkill = $this->createNewChildSkill($deepestSkill);
            }  catch (Exception $e) {
                $this->error($e->getMessage());
            }

            $this->benchmarkResults[] = $benchmarks;

            $numberOfChildSkills++;
        } while ($numberOfChildSkills < $skillsDepth);

        $this->printAverageQueryTime($this->benchmarkResults);
        $this->exportAverageQueryTimePerDepth($this->benchmarkResults);

        return 0;
    }

    private function createNewChildSkill(Skill $parentSkill): Skill
    {
        return Skill::factory()->create([
            'parent_id'  => $parentSkill->id,
        ]);
    }

    /**
     * @return float seconds
     */
    private function benchmarkQuery(Skilltree $skilltree): float
    {
        $query = Skill::whereNull('parent_id')
            ->where('skilltree_id', $skilltree->id)
            ->unionAll(
                Skill::select('skills.*')
                    ->join('tree', 'tree.id', '=', 'skills.parent_id')
            );

        $tree = Skill::from('tree')
            ->withRecursiveExpression('tree', $query)
            ->getQuery();

        $startTime = microtime(true);
        $tree->get();
        $endTime = microtime(true);

        return $endTime - $startTime;
    }

    private function printAverageQueryTime(array $benchmarkResults)
    {
        dump($this->benchmarkResults);
        $flatten = collect($this->benchmarkResults)->flatten();
        $numberOfBenchmarks = $flatten->count();
        $sum = $flatten->sum();

        $averageQueryTime = $sum / $numberOfBenchmarks;

        $this->info('Average query time: ' . $averageQueryTime . 'ms' );
    }

    private function exportAverageQueryTimePerDepth(array $benchmarkResults)
    {
        $csvMemoryStream = fopen('php://temp/maxmemory:'.self::MEMORY_STREAM_20MB, 'rw+');
        fputcsv($csvMemoryStream, [
            'Node level',
            'Query time(ms)',
        ], self::CSV_SEPARATOR);

        collect($benchmarkResults)->each(function ($depthBenchmarks, $index) use($csvMemoryStream) {
            fputcsv($csvMemoryStream, [
                'Node level' => $index + 1,
                'Query time(ms)' => collect($depthBenchmarks)->avg(),
            ], self::CSV_SEPARATOR);
        });

        $fileName = sprintf(
            '%s-postgresql-benchamrks.csv',
            Carbon::now()->format('Y-m-d-H-i-s-u'),
        );

        $disk = $this->filesystemManager->disk('local');
        $disk->writeStream($fileName, $csvMemoryStream);
        fclose($csvMemoryStream);
    }
}
