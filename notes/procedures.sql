create or replace procedure member_img_upload(imgname varchar2, msr number) is 
ab blob; 
abfile bfile := bfilename('MEMBERPICS', imgname) ; 
begin 
	update
	    memberinfo
	set
	    memberpic = empty_blob()
	where
	    membersr = msr returning memberpic into ab;
	dbms_lob.fileopen(abfile);
	dbms_lob.loadfromfile(ab,abfile,dbms_lob.getlength(abfile));
	dbms_lob.fileclose(abfile);
	commit;
end member_img_upload;

create or replace procedure member_sign_upload(imgname varchar2, id number) is 
ab blob; 
abfile bfile := bfilename('MEMBERPICS', imgname); 
begin 
	update
	    memberinfo
	set
	    membersign = empty_blob()
	where
	    membersr = id returning membersign into ab;
	dbms_lob.fileopen(abfile);
	dbms_lob.loadfromfile(ab,abfile,dbms_lob.getlength(abfile));
	dbms_lob.fileclose(abfile);
	commit;
end member_sign_upload; 

-- Create directory 
create or replace directory MEMBERPICS
  as 'D:\_DHA\NEW_ERP\v1\Membership\l1\storage\app\public\images\memberpics';


SELECT
    t.fkmembersr,
    t.memberid,
    t.membername,
    t.dob,
    t.relation,
    t.creditallow,
    t.edate,
    t.tsr,
    t.euser,
    t.srno,
    t.enb,
    t.vno,
    t.cardissuedate,
    t.cardexpirydate,
    t.other,
    t.vnomemberfamily,
    t.memberidnew,
    t.memberidnew1,
    t.picture,
    t.signature,
    t.created_at_date,
    t.updated_at_date
FROM
    MEMBERFAMILY t;

select
    t.membersr,
    t.memberid,
    t.membername,
    t.cnic
from
    memberinfo t
where
    LENGTH(t.cnic) < 14