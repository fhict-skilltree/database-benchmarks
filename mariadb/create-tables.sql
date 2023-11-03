create table skill_assessments
(
    id          bigint auto_increment
        primary key,
    is_approved tinyint(1) null,
    assessed_at datetime   not null,
    skill_id    bigint     not null,
    student_id  bigint     not null,
    teacher_id  bigint     not null
);


create table skill_evidences
(
    id          bigint auto_increment
        primary key,
    explanation text   not null,
    skill_id    bigint not null,
    student_id  bigint not null
);

create table skills
(
    id              bigint auto_increment
        primary key,
    title           varchar(255) null,
    content         text         null,
    skilltree_id    bigint       not null,
    parent_skill_id bigint       null
);


create table skilltree_student
(
    skilltree_id bigint not null,
    student_id   bigint not null
);

create table skilltree_teacher
(
    skilltree_id bigint not null,
    tacher_id    bigint not null
);


create table skilltrees
(
    id    bigint auto_increment
        primary key,
    title varchar(255) not null
);

create table students
(
    id         bigint auto_increment
        primary key,
    first_name varchar(255) not null,
    last_name  varchar(255) not null
);

create table teachers
(
    id         bigint auto_increment
        primary key,
    first_name varchar(255) not null,
    last_name  varchar(255) not null
);

