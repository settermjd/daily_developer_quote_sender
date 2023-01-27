-- we don't know how to generate root <with-no-name> (class Root) :(
create table quote_authors
(
    author_id   uuid default gen_random_uuid() not null
        primary key,
    author_name varchar(200)                   not null
);

create table quotes
(
    quote_id     uuid default gen_random_uuid() not null
        primary key,
    quote_text   varchar(300)                   not null,
    quote_author uuid
        constraint fk_q_author
            references quote_authors,
    constraint developer_quotes__ui_author_quote
        unique (quote_author, quote_text)
);

create table quote_users
(
    user_id   uuid default gen_random_uuid() not null
        primary key,
    full_name varchar(36)                    not null,
    mobile_number varchar(18)                null,
    email_address text                       null
);

create unique index quote_users__ui_email_address
    on quote_users (lower(email_address));

create unique index quote_users__ui_mobile_number
    on quote_users (mobile_number);

create table quote_views
(
    quote_id uuid not null
        constraint fk_qv_quote
            references quotes,
    user_id  uuid not null
        constraint fk_qv_user
            references quote_users,
    primary key (quote_id, user_id)
);

insert into quote_users values ('df882391-f22c-4124-a190-2e59a5da824f', 'Anthony Kiedis');
insert into quote_users values ('e73309ff-1b4f-4e4a-84ad-8c6420c36f8a', 'John Frusciante');
insert into quote_users values ('c151a4a6-8fda-4588-8291-6d1822c00c75', 'Chad Smith');
insert into quote_users values ('b0a6eeee-cd66-4cf9-bd83-0f9197af5488', 'Flea (Michael Balzary');

insert into quote_authors values ('0b067173-dfd8-4951-8865-4cd64a1e2675', 'Vidiu Platon');
insert into quote_authors values ('3cec7ec4-bf76-4c84-aa02-b8d311e26ead', 'Kent Beck');
insert into quote_authors values ('4f001d6e-a668-46e9-bf3c-638d051d466f', 'Steve Wozniak');
insert into quote_authors values ('6b5503fb-487b-4a1f-833f-f4be7711c1c3', 'Donald Knuth');
insert into quote_authors values ('7e65797e-774a-4b24-940d-282ba0d5d763', 'Larry Wall');
insert into quote_authors values ('ad5621e3-f0b8-461e-a9e6-501d9a1edff8', 'Brian Kernighan');
insert into quote_authors values ('d7af53bc-526a-4227-803d-a15d7963f959', 'Martin Fowler');
insert into quote_authors values ('e6ca7129-1249-4a59-b52e-6d275aad37ca', 'Linus Torvalds');
insert into quote_authors values ('f01fc169-1e78-4da3-9df7-498b8d9410ab', 'Jeff Atwood');
insert into quote_authors values ('f8dd2bab-61f6-43de-b24e-310853003bbf', 'Edsger W. Dijkstra');
insert into quote_authors values ('4b41f194-fe09-49fe-9276-fc15c03a9d3e', 'Anonymous/Unknown');
insert into quote_authors values ('f3f47fa1-929d-4e14-9424-9807af4fbce5', 'John Romero');
insert into quote_authors values ('1aa4b7be-55af-4670-b9d2-08c7d78cd4fc', 'Ellen Ullman');

insert into quotes values('a6b17758-21b9-4b9c-acca-7ccad2a78077', 'Bad programmers worry about the code. Good programmers worry about data structures and their relationships.', 'e6ca7129-1249-4a59-b52e-6d275aad37ca');
insert into quotes values('c2a84efb-3729-4963-b457-be312423fd15', 'If you optimize everything, you will always be unhappy.', '6b5503fb-487b-4a1f-833f-f4be7711c1c3');
insert into quotes values('2fa62d31-f716-4b20-932a-2fa451f9eaab', 'We have to stop optimizing for programmers and start optimizing for users.', 'f01fc169-1e78-4da3-9df7-498b8d9410ab');
insert into quotes values('d429bc68-54ae-4113-bd80-675b367e6488', 'If debudding is the process of removing software bugs, then programming must be the process of putting them in.', 'f8dd2bab-61f6-43de-b24e-310853003bbf');
insert into quotes values('ce2bdb0c-befc-41a3-b069-a533073300e8', 'I don''t care if it works on your machine! We are not shipping your machine!', '0b067173-dfd8-4951-8865-4cd64a1e2675');
insert into quotes values('27d46e16-dd24-44ba-91b2-be555c3a7e24', 'Don''t comment bad code - rewrite it.', 'ad5621e3-f0b8-461e-a9e6-501d9a1edff8');
insert into quotes values('6b755625-e10e-42db-af6f-04a574b9673b', 'Make it work, make it right, make it fast.', '3cec7ec4-bf76-4c84-aa02-b8d311e26ead');
insert into quotes values('5b59c61c-e1d6-4245-90e4-106b419e9498', 'Any fool can write code that a computer can understand. Good programmers write code that humans can understand.', 'd7af53bc-526a-4227-803d-a15d7963f959');
insert into quotes values('7d868bbf-c3a4-4473-8c30-840944b16dcb', 'When to use iterative development? You should use iterative development only on projects that you want to succeed.', 'd7af53bc-526a-4227-803d-a15d7963f959');
insert into quotes values('c95c62ab-8efc-47f7-92e2-daccc6167c6b', 'Programmer: A machine that turns coffee into code.', '4b41f194-fe09-49fe-9276-fc15c03a9d3e');
insert into quotes values('7d2c3757-ccf6-447f-99e7-eeccc66debd2', 'You might not think that programmers are artists, but programming is an extremely creative profession. It’s logic-based creativity.', 'f3f47fa1-929d-4e14-9424-9807af4fbce5');
insert into quotes values('fdb02f9e-5ed3-4693-a18f-4aa04122b2f1', 'There is always one more bug to fix.', '1aa4b7be-55af-4670-b9d2-08c7d78cd4fc');

insert into quote_views values('a6b17758-21b9-4b9c-acca-7ccad2a78077', 'df882391-f22c-4124-a190-2e59a5da824f');
insert into quote_views values('ce2bdb0c-befc-41a3-b069-a533073300e8', 'df882391-f22c-4124-a190-2e59a5da824f');
insert into quote_views values('7d2c3757-ccf6-447f-99e7-eeccc66debd2', 'df882391-f22c-4124-a190-2e59a5da824f');
insert into quote_views values('a6b17758-21b9-4b9c-acca-7ccad2a78077', 'b0a6eeee-cd66-4cf9-bd83-0f9197af5488');
