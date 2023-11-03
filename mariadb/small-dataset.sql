INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (1, 'Versiebeheer', null, 1, null);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (2, 'Git Basics', null, 1, 1);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (3, 'Repositories', null, 1, 2);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (4, 'Colloborating', null, 1, 2);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (5, 'Git Init', null, 1, 3);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (6, 'Cloning', null, 1, 3);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (7, 'Committing', null, 1, 6);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (8, 'Reverting commits', null, 1, 6);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (9, 'Using branches', null, 1, 4);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (10, 'Syncing', null, 1, 4);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (11, 'Making a pull request', null, 1, 4);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (12, 'Reverting commits', null, 1, 9);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (13, 'Committing', null, 1, 10);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (14, 'Reverting commits', null, 1, 10);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (15, 'Committing', null, 1, 11);
INSERT INTO skilltree.skills (id, title, content, skilltree_id, parent_skill_id) VALUES (16, 'Reverting commits', null, 1, 11);

INSERT INTO skilltree.skilltrees (id, title) VALUES (1, 'Skilltree voor voltijd HBO-ICT');

INSERT INTO skilltree.students (id, first_name, last_name) VALUES (1, 'Sandra', 'Jansen');

INSERT INTO skilltree.teachers (id, first_name, last_name) VALUES (1, 'Peter', 'van Nieuwkerk');


INSERT INTO skilltree.skill_assessments (id, is_approved, assessed_at, skill_id, student_id, teacher_id) VALUES (1, 1, '2023-10-22 22:42:08', 4, 1, 1);
