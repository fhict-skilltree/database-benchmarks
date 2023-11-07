<?php

namespace App\Console\Commands;

use App\Models\Skill;
use App\Models\Skilltree;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;

class BenchmarkMongodbCommand extends Command
{
    private const MEMORY_STREAM_20MB = 20971520;
    private const CSV_SEPARATOR = ';';

    protected $signature = 'app:benchmark-mongodb {skills-depth} {benchmark-count} {sleep-after-query}';

    protected $description = '';

    private FilesystemManager $filesystemManager;

    private array $benchmarkResults = [];

    public function handle(FilesystemManager $filesystemManager): int
    {
        $this->filesystemManager = $filesystemManager;

        $skillsDepth = (int)$this->argument('skills-depth');
        $benchmarkCount = (int)$this->argument('benchmark-count');
        $sleepAfterQuery = (int)$this->argument('sleep-after-query');

        $this->info('Starting benchmarks:');
        $this->info('Skills depth: ' . $skillsDepth);

        $numberOfChildSkills = 1;
        do {
            $numberOfBenchmarks = 0;
            $benchmarks = [];
            $this->createNewSkilltree($numberOfChildSkills);

            while ($numberOfBenchmarks < $benchmarkCount) {
                try {
                    $benchmarks[] = $s = $this->benchmarkQuery() * 1000;
                    $this->info('Time: ' . $s . 'ms');
                    usleep($sleepAfterQuery);

                } catch (Exception $e) {
                    $this->error($e->getMessage());
                } finally {
                    $numberOfBenchmarks++;
                }
            }

            $this->benchmarkResults[] = $benchmarks;

            $numberOfChildSkills++;
        } while ($numberOfChildSkills < $skillsDepth);

        $this->printAverageQueryTime($this->benchmarkResults);
        $this->exportAverageQueryTimePerDepth($this->benchmarkResults);

        return 0;
    }

    private function createNewSkilltree($depth): void
    {
        try {
            Artisan::call('migrate:fresh');
        }  catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $skilltree = Skilltree::factory()
            ->create();

        $this->seedSkill($skilltree, null, 0, $depth);
    }

    private function seedSkill($skilltree, $parent = null, $depth = 0, int $maxDepth) {
        if ($depth <= $maxDepth) {
            $skill = Skill::factory()->create([
                'skilltree_id' => $depth === 0
                    ? $skilltree->id
                    : null,
                "parent" => $parent?->id,
                "ancestors" => $parent === null
                    ? []
                    : array_merge([$parent->id], $parent->ancestors),
            ]);

            $this->seedSkill($skilltree, $skill, $depth + 1, $maxDepth);
        }
    }

    /**
     * @return float seconds
     */
    private function benchmarkQuery(): float
    {
        $skill = Skill::first();

        $startTime = microtime(true);
        Skill::whereIn('ancestors', [$skill->id])->get();
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
            '%s-mongodb-array-of-ancestors-benchamrks.csv',
            Carbon::now()->format('Y-m-d-H-i-s-u'),
        );

        $disk = $this->filesystemManager->disk('local');
        $disk->writeStream($fileName, $csvMemoryStream);
        fclose($csvMemoryStream);
    }
}
