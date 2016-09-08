create table administration(login varchar2(30) primary key,password varchar2(50));

create table etudiants(codepermanent varchar2(50) primary key,nometud varchar2(50),
prenometud varchar2(50),datenaissance date, teletud varchar2(50),
leno number(6),rue varchar2(50),ville varchar2(50),codepostal varchar2(6),province varchar2(2)
,photo varchar2(90),nogroupe varchar2(20),password varchar2(50));

create table profs(noprof varchar2(50) primary key,nomprof varchar2(50),
prenomprof varchar2(50),telprof varchar2(50),photo varchar2(90),password varchar2(50));

create table cours(nocours varchar2(50) primary key,nomcours varchar2(50),
descripcours varchar2(50),prixcours varchar2(50));

create table inscription(codepermanent varchar2(50),nocours varchar2(50),
lasession varchar2(50),noprof varchar2(50),notefinale number(2,2),
CONSTRAINT pk_inscription Primary Key(codepermanent,nocours,lasession),
CONSTRAINT fk_codepermanent Foreign Key(codepermanent) References etudiants(codepermanent),
CONSTRAINT fk_nocours Foreign Key(nocours) References cours(nocours),
CONSTRAINT fk_noprof Foreign Key(noprof) References profs(noprof)
ON DELETE CASCADE);







