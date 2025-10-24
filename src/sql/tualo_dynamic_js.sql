delimiter ;
create table if not exists tualo_dynamic_javascript (
    id varchar(255) not null primary key,
    sourcecode longtext,
    md5sum varchar(32),
    description varchar(255),
    active tinyint default 1,
    preload tinyint default 0,
    created_at timestamp default current_timestamp,
    updated_at timestamp default current_timestamp on update current_timestamp
);

alter table tualo_dynamic_javascript
    add column if not exists depends_on_id varchar(255) default null ;

alter table tualo_dynamic_javascript
    add 
    
    constraint fk_tualo_dynamic_javascript_depends_on_id
    
    foreign key IF NOT EXISTS (depends_on_id) 
    
    references tualo_dynamic_javascript(id)
    on delete set null
    on update cascade
;