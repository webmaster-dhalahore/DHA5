DECLARE
	mt varchar2(20);
begin	

if :bill_mst.memberid is null then
	list_Values;
else

select MEMBERNAME,membersr,membertype,nvl(blockstatus,'BLOCK') into :bill_mst.memberdes,:bill_mst.fkmembersr,mt,:mstatus from memberinfo where memberinfo.memberid=:bill_mst.memberid;




if mt='MEMBER' THEN
select nvl(membersubscription.dhadiscount,0) into :bill_mst.DISCPERC	from membersubscription where membersubscription.typeid=(select memberinfo.typeid from memberinfo where memberid=:bill_mst.memberid);
	
	:bill_mst.pay_mode:='R';
else

	:bill_mst.pay_mode:='C';
	end if;
--IF MEMBER CHANGED FROM DISCOUNT TO NON DISCOUNT, THEN REMOVE DISCOUNT
IF NVL(:DISCPERC,0)<=0 THEN 
	go_block('BILL_DTL');
FIRST_RECORD;
    LOOP
    IF :QTY IS NULL THEN 
    	DELETE_RECORD;
    END IF;		
   :DISCT:=0;
    EXIT WHEN :SYSTEM.LAST_RECORD = 'TRUE';
    NEXT_RECORD;            
    END LOOP;   

	go_item('BILL_MST.MEMBERID');
END IF; 


--IF MEMBER CHANGED FROM NON DISCOUNT TO DISCOUNT, THEN APPLY DISCOUNT
IF NVL(:DISCPERC,0)>0 THEN
go_block('BILL_DTL');
FIRST_RECORD;
    LOOP
    IF :QTY IS NULL THEN 
    	DELETE_RECORD;
    END IF;		
    IF NVL(:DISCPERC,0)>0 THEN
		if :itemtp='4'  THEN
		:DISCT:=0;
		else
		:DISCT:= ((NVL(:QTY,0) * NVL(:RATE,0))*(:DISCPERC/100));
		END IF;	
		END IF;	
    EXIT WHEN :SYSTEM.LAST_RECORD = 'TRUE';
    NEXT_RECORD;            
    END LOOP;   
   	go_item('BILL_MST.MEMBERID');

END IF;





if :mstatus='CANCEL' OR :mstatus='cancel' OR :mstatus='BLOCK' OR :mstatus='block' or :mstatus='OUTSTATION' OR :mstatus ='outstation' then
	
	SET_ITEM_PROPERTY('BILL_DTL.ITEM_ID',ENABLED,PROPERTY_FALSE);
	go_block('BILL_DTL');
	clear_block(no_validate);
	go_item('BILL_MST.MEMBERID');
	
ELSE
		SET_ITEM_PROPERTY('BILL_DTL.ITEM_ID',ENABLED,PROPERTY_TRUE);

  next_item;
 END IF; 	
end if;
end;