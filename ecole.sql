create tablespace ecole
datafile 'C:\TP\PROJET\ECOLE.DBF'
size 512M autoextend on next 256M;

create user usrecole identified by oracle
Default tablespace ecole
Temporary tablespace temp;

Grant connect, resource, dba, imp_full_database to usrecole;
Grant all privileges to usrecole;
