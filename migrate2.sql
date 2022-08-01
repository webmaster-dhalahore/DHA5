
Warning: PHP Startup: Unable to load dynamic library 'oci8_12c' (tried: C:\xampp\php\ext\oci8_12c (The specified module could not be found), C:\xampp\php\ext\php_oci8_12c.dll (The specified module could not be found)) in Unknown on line 0
2014_10_12_000000_create_users_table: create table users ( id number(19,0) not null, name varchar2(255) not null, username varchar2(255) not null, email varchar2(255) null, "PASSWORD" varchar2(255) not null, is_active char(1) default '0' not null, is_admin varchar2(255) null, club_id number(10,0) null, last_login timestamp null, created_by number(10,0) null, remember_token varchar2(100) null, created_at timestamp null, updated_at timestamp null, constraint users_id_pk primary key ( id ) )
2014_10_12_000000_create_users_table: create unique index users_username_uk on users (lower(username))
2014_10_12_000000_create_users_table: create sequence users_id_seq minvalue 1  start with 1 increment by 1 
2014_10_12_000000_create_users_table: 
            create trigger users_id_trg
            before insert on USERS
            for each row
                begin
            if :new.ID is null then
                select users_id_seq.nextval into :new.ID from dual;
            end if;
            end;
2014_10_12_100000_create_password_resets_table: create table password_resets ( email varchar2(255) not null, token varchar2(255) not null, created_at timestamp null )
2014_10_12_100000_create_password_resets_table: create index password_resets_email_index on password_resets ( email )
2019_08_19_000000_create_failed_jobs_table: create table failed_jobs ( id number(19,0) not null, uuid varchar2(255) not null, connection clob not null, "QUEUE" clob not null, payload clob not null, exception clob not null, failed_at timestamp not null, constraint failed_jobs_id_pk primary key ( id ) )
2019_08_19_000000_create_failed_jobs_table: create unique index failed_jobs_uuid_uk on failed_jobs (lower(uuid))
2019_08_19_000000_create_failed_jobs_table: create sequence failed_jobs_id_seq minvalue 1  start with 1 increment by 1 
2019_08_19_000000_create_failed_jobs_table: 
            create trigger failed_jobs_id_trg
            before insert on FAILED_JOBS
            for each row
                begin
            if :new.ID is null then
                select failed_jobs_id_seq.nextval into :new.ID from dual;
            end if;
            end;
2019_12_14_000001_create_personal_access_tokens_table: create table personal_access_tokens ( id number(19,0) not null, tokenable_type varchar2(255) not null, tokenable_id number(19,0) not null, name varchar2(255) not null, token varchar2(64) not null, abilities clob null, last_used_at timestamp null, created_at timestamp null, updated_at timestamp null, constraint personal_access_tokens_id_pk primary key ( id ) )
2019_12_14_000001_create_personal_access_tokens_table: create index per_ac_to_toke_ty_toke_id_in on personal_access_tokens ( tokenable_type, tokenable_id )
2019_12_14_000001_create_personal_access_tokens_table: create unique index persona_acces_token_toke_uk on personal_access_tokens (lower(token))
2019_12_14_000001_create_personal_access_tokens_table: create sequence personal_access_tokens_id_seq minvalue 1  start with 1 increment by 1 
2019_12_14_000001_create_personal_access_tokens_table: 
            create trigger personal_access_tokens_id_trg
            before insert on PERSONAL_ACCESS_TOKENS
            for each row
                begin
            if :new.ID is null then
                select personal_access_tokens_id_seq.nextval into :new.ID from dual;
            end if;
            end;
2022_06_08_171313_create_clubs_table: create table clubs ( id number(19,0) not null, name varchar2(255) not null, code varchar2(255) not null, address varchar2(255) null, phone_number varchar2(255) null, created_at timestamp null, updated_at timestamp null, constraint clubs_id_pk primary key ( id ) )
2022_06_08_171313_create_clubs_table: create sequence clubs_id_seq minvalue 1  start with 1 increment by 1 
2022_06_08_171313_create_clubs_table: 
            create trigger clubs_id_trg
            before insert on CLUBS
            for each row
                begin
            if :new.ID is null then
                select clubs_id_seq.nextval into :new.ID from dual;
            end if;
            end;
2022_06_08_172829_add_columns_to_memberinfo_table: alter table memberinfo add ( club_id number(10,0) null, rank varchar2(255) null, parent_membersr number(10,0) null, picture varchar2(255) null, signature varchar2(255) null, created_by number(10,0) null, updated_by number(10,0) null, mobileno2 varchar2(255) null, created_at timestamp null, updated_at timestamp null )
2022_06_08_174256_add_columns_to_memberfamily_table: alter table memberfamily add ( picture varchar2(255) null, signature varchar2(255) null, created_by number(10,0) null, updated_by number(10,0) null, deleted_by number(10,0) null, membership_form date null, deleted_at timestamp null, created_at timestamp null, updated_at timestamp null )
CreatePermissionTables: create table permissions ( id number(10,0) not null, name varchar2(255) not null, guard_name varchar2(255) not null, created_at timestamp null, updated_at timestamp null, constraint permissions_id_pk primary key ( id ) )
CreatePermissionTables: create unique index permissions_name_guard_name_uk on permissions (lower(name), lower(guard_name))
CreatePermissionTables: create sequence permissions_id_seq minvalue 1  start with 1 increment by 1 
CreatePermissionTables: 
            create trigger permissions_id_trg
            before insert on PERMISSIONS
            for each row
                begin
            if :new.ID is null then
                select permissions_id_seq.nextval into :new.ID from dual;
            end if;
            end;
CreatePermissionTables: create table roles ( id number(19,0) not null, name varchar2(255) not null, guard_name varchar2(255) not null, created_at timestamp null, updated_at timestamp null, constraint roles_id_pk primary key ( id ) )
CreatePermissionTables: create unique index roles_name_guard_name_uk on roles (lower(name), lower(guard_name))
CreatePermissionTables: create sequence roles_id_seq minvalue 1  start with 1 increment by 1 
CreatePermissionTables: 
            create trigger roles_id_trg
            before insert on ROLES
            for each row
                begin
            if :new.ID is null then
                select roles_id_seq.nextval into :new.ID from dual;
            end if;
            end;
CreatePermissionTables: create table model_has_permissions ( permission_id number(10,0) not null, model_type varchar2(255) not null, model_id number(10,0) not null, constraint mo_ha_permissi_permiss_id_fk foreign key ( permission_id ) references permissions ( id ) on delete cascade, constraint mhp_permission_model_type_pk primary key ( permission_id, model_id, model_type ) )
CreatePermissionTables: create index mhp_model_id_model_type_idx on model_has_permissions ( model_id, model_type )
CreatePermissionTables: create table model_has_roles ( role_id number(10,0) not null, model_type varchar2(255) not null, model_id number(10,0) not null, constraint model_has_roles_role_id_fk foreign key ( role_id ) references roles ( id ) on delete cascade, constraint mhr_role_model_type_primary primary key ( role_id, model_id, model_type ) )
CreatePermissionTables: create index mhr_model_id_model_type_idx on model_has_roles ( model_id, model_type )
CreatePermissionTables: create table role_has_permissions ( permission_id number(10,0) not null, role_id number(10,0) not null, constraint ro_ha_permissio_permissi_id_fk foreign key ( permission_id ) references permissions ( id ) on delete cascade, constraint rol_ha_permission_rol_id_fk foreign key ( role_id ) references roles ( id ) on delete cascade, constraint rhp_permission_id_role_id_pk primary key ( permission_id, role_id ) )
2022_06_13_113501_create_emails_mst_table: create table emails_mst ( id number(19,0) not null, title varchar2(255) not null, user_id number(10,0) null, created_at timestamp null, updated_at timestamp null, constraint emails_mst_id_pk primary key ( id ) )
2022_06_13_113501_create_emails_mst_table: create sequence emails_mst_id_seq minvalue 1  start with 1 increment by 1 
2022_06_13_113501_create_emails_mst_table: 
            create trigger emails_mst_id_trg
            before insert on EMAILS_MST
            for each row
                begin
            if :new.ID is null then
                select emails_mst_id_seq.nextval into :new.ID from dual;
            end if;
            end;
2022_06_13_113501_create_emails_mst_table: create table emails_dtl ( id number(19,0) not null, emails_mst_id number(10,0) null, membersr number(10,0) not null, membername varchar2(255) not null, email varchar2(255) not null, is_success char(1) null, created_at timestamp null, updated_at timestamp null, constraint emails_dtl_id_pk primary key ( id ) )
2022_06_13_113501_create_emails_mst_table: create sequence emails_dtl_id_seq minvalue 1  start with 1 increment by 1 
2022_06_13_113501_create_emails_mst_table: 
            create trigger emails_dtl_id_trg
            before insert on EMAILS_DTL
            for each row
                begin
            if :new.ID is null then
                select emails_dtl_id_seq.nextval into :new.ID from dual;
            end if;
            end;
2022_06_13_200004_create_user_menu_table: create table user_menu ( id number(19,0) not null, permission_id number(10,0) null, menu_name varchar2(255) not null, parent_id number(10,0) null, route varchar2(255) null, param1 varchar2(255) null, is_active char(1) default 'Y' not null, created_at timestamp null, updated_at timestamp null, constraint user_menu_id_pk primary key ( id ) )
2022_06_13_200004_create_user_menu_table: create sequence user_menu_id_seq minvalue 1  start with 1 increment by 1 
2022_06_13_200004_create_user_menu_table: 
            create trigger user_menu_id_trg
            before insert on USER_MENU
            for each row
                begin
            if :new.ID is null then
                select user_menu_id_seq.nextval into :new.ID from dual;
            end if;
            end;
CreateActivityLogTable: create table activity_log ( id number(19,0) not null, log_name varchar2(255) null, description clob not null, subject_type varchar2(255) null, subject_id number(19,0) null, causer_type varchar2(255) null, causer_id number(19,0) null, properties clob null, created_at timestamp null, updated_at timestamp null, constraint activity_log_id_pk primary key ( id ) )
CreateActivityLogTable: create index subject on activity_log ( subject_type, subject_id )
CreateActivityLogTable: create index causer on activity_log ( causer_type, causer_id )
CreateActivityLogTable: create index activity_log_log_name_index on activity_log ( log_name )
CreateActivityLogTable: create sequence activity_log_id_seq minvalue 1  start with 1 increment by 1 
CreateActivityLogTable: 
            create trigger activity_log_id_trg
            before insert on ACTIVITY_LOG
            for each row
                begin
            if :new.ID is null then
                select activity_log_id_seq.nextval into :new.ID from dual;
            end if;
            end;
AddEventColumnToActivityLogTable: alter table activity_log add ( event varchar2(255) null )
AddBatchUuidColumnToActivityLogTable: alter table activity_log add ( batch_uuid char(36) null )
