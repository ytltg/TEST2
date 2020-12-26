<?php

function create_User($name,$email,$password,$phone)
{
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO User (name,email,password,phone) VALUES (?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$name,$email,$password,$phone]);

    $st = null;
    $pdo = null;

}
//READ
function getUsers()
{
    $pdo = pdoSqlConnect();
    $query = "select * from User" ;

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//READ
function getUserDetail($userIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select * from User where ID = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}
//----------------------------------- Valid 모음 -----------------------------------------------------------

//READ
// 유저아이디 검색 조건
function isValidUserIdx($userIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from user where id = ? and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
//아이템 아이디 검색 조건
function isValiditemIdx($itemIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from item where id = ? and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
//판매자 아이디 검색 조건
function isValidSellerIdx($itemIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from seller where id = ? and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
//쿠폰 아이디 검색 조건
function isValidCouponIdx($itemIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from coupon where id = ? and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
//댓글 아이디 있나 확인
function isValidCommentsIdx($userIdx,$itemIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from comment where user_num = ? and item_num=? and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx,$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
function isValidRecentsIdx($userIdx,$itemIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from recent_view where user_num = ? and item_num=? and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx,$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}

//즐겨찾기 이미 같은게 존재하나 검색
function isValidStarIdx($userIdx,$itemIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from star where user_num = ? and seller_num=? and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx,$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
//쿠폰 이미 같은게 존재하나 검색
function isValidGetCouponIdx($userIdx,$itemIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from get_coupon where user_num = ? and coupon_num=? and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx,$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}

//즐겨찾기가 0개인가 검색
function isValidStar_zeroIdx($userIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from star where user_num = ?  and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
//하트 같은게 있나 검색
function isValidHeartIdx($userIdx,$itemIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from heart where user_num = ? and item_num=? and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx,$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
//예약 같은게 있나 검색
function isValidReserveIdx($userIdx,$itemIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from reserve where user_num = ? and item_num=? and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx,$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
//장바구니가 0개인가 검색
function isValidReserve_zeroIdx($userIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from reserve where user_num = ?  and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
//구매목록에 있는지 체크
function isValidBuylistIdx($userIdx,$itemIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from buy_list where user_num = ? and item_num=? and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx,$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
//댓글 있나 체크
function isValidGetCommentsIdx($userIdx,$itemIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from comment where user_num = ? and item_num=? and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx,$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
//장바구니가 0개인가 검색
function isValidBuylist_zeroIdx($userIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from buy_list where user_num = ?  and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}
//쿠폰 0개인가 검색
function isValidCoupon_zeroIdx($userIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from get_coupon where user_num = ?  and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}

function isValidComments_zeroIdx($userIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select EXISTS(select * from comment where user_num = ?  and status =100) exist;";

    $st = $pdo->prepare($query);
    $st->execute([$userIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0]['exist'];
}

//---------------------------------------- API 모음 -------------------------------------------------
//4. 마이페이지
function getMypage($userID)
{
    $pdo = pdoSqlConnect();
    $query = "select DISTINCT u.id, u.name, u.rank1 from user as u
where u.id = ?";

    $st = $pdo->prepare($query);
    $st->execute([$userID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}
//5.아이템 리스트 조회
function get_items()
{
    $pdo = pdoSqlConnect();
    $query = "select i.id, item_name,i.image , i.price,i.discount, s.seller_name,i.category,i.status ,count(h.ID)as heart from item as i
join seller as s
on s.ID = i.seller_num
left join heart as h
on i.id = h.item_num
group by i.id
ORDER BY (Select count(*) from buy_list where item_num = i.ID) desc ;" ;
    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}
function get_items_page($page)
{
    $pdo = pdoSqlConnect();

    $query =
        "select b.*
from(
select @rownum:=@rownum+1 as no, i.id, item_name,i.image , i.price,i.discount, s.seller_name,i.category,i.status , count(h.ID)as heart
from item as i
join seller as s
on s.ID = i.seller_num
left join heart as h
on i.id = h.item_num
WHERE (@rownum:=0)=0
group by i.id
ORDER BY (Select count(*) from buy_list where item_num = i.ID) desc) b
where b.no >?;
" ;

    $st = $pdo->prepare($query);
    $st->execute([$page]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;

}
//5(1)아이템 검색
function get_item_search($itemIdx)
{
    $pdo = pdoSqlConnect();
    $query = "select i.id, item_name,i.image , i.price,i.discount, s.seller_name,i.category,i.status ,count(h.ID)as heart from item as i
join seller as s
on s.ID = i.seller_num
left join heart as h
on i.id = h.item_num
where item_name Like concat('%',?,'%')
group by i.id
ORDER BY (Select count(*) from buy_list where item_num = i.ID) desc
;";

    $st = $pdo->prepare($query);
    $st->execute([$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}
//6.아이템 상세정보
function get_item_Detail($itemIdx)
{
    $pdo = pdoSqlConnect();
    $query =
        "SELECT i.id, i.item_name,''as image2,  i.image, i.price,i.discount,s.seller_name,i.category,i.status, count(h.id)as is_heart
from item as i
left join seller as s
ON i.seller_num = s.ID
left join heart as h
on i.id = h.item_num
where h.user_num=i.id and i.ID =?;";

    $st = $pdo->prepare($query);
    $st->execute([$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res1 = $st->fetchAll();

    $st = null;

    $query3="select i.image
from image_detail as i
where i.item_num = ?;";
    $st = $pdo->prepare($query);
    $st->execute([$itemIdx]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res3 = $st->fetchAll();

    $st = null;
    $pdo = null;
$res = $res1+$res3;


    return $res[0];
}
//7,즐찾 추가
function create_Star($user_num,$seller_num,$createAt,$updateAt,$status)
{
    //,$req->seller_num,$req->createAT,$req->updateAt,$req->status
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO star (user_num,seller_num,createAt,updateAt,status) VALUES (?,?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$user_num,$seller_num,$createAt,$updateAt,$status]);

    $st = null;
    $pdo = null;

}
//8.즐찾 조회
function get_Star($userID)
{
    $pdo = pdoSqlConnect();
    $query = "select s.ID, s.image, s.seller_name
from seller as s
join star as st On st.seller_num = s.ID
where st.user_num = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}
//9.즐찾 삭제
function delete_Star($userID,$sellerID)
{
    $pdo = pdoSqlConnect();
    $query = "delete
from star as st
where st.user_num = ? and st.seller_num = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userID, $sellerID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
     //$res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return null; //$res[0];
}
//10. 찜 생성
function create_Heart($user_num,$item_num,$createAt,$updateAt,$status)
{
    //,$req->seller_num,$req->createAT,$req->updateAt,$req->status
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO heart (user_num,item_num,createAt,updateAt,status) VALUES (?,?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$user_num,$item_num,$createAt,$updateAt,$status]);

    $st = null;
    $pdo = null;

}
//11. 찜 조회
function get_heart($userID)
{
    $pdo = pdoSqlConnect();
    $query = "select i.id, item_name,i.image , i.price,i.discount, s.seller_name,i.category,i.status ,count(h.ID)as heart from item as i
join seller as s
on s.ID = i.seller_num
left join heart as h
on i.id = h.item_num
where i.id =?
group by i.id
ORDER BY (Select count(*) from buy_list where item_num = i.ID) desc ;" ;

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([$userID]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}
//12. 찜 삭제
function delete_Heart($userID,$itemID)
{
    $pdo = pdoSqlConnect();
    $query = "delete
from heart as h
where h.user_num = ? and h.item_num = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userID, $itemID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    //$res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return null; //$res[0];
}
//13.장바구니 생성
function create_Reserves($user_num,$item_num,$createAt,$updateAt,$status,$num,$option_name)
{
    //,$req->seller_num,$req->createAT,$req->updateAt,$req->status
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO reserve (user_num,item_num,createAt,updateAt,status,num,option_name) VALUES (?,?,?,?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$user_num,$item_num,$createAt,$updateAt,$status,$num,$option_name]);

    $st = null;
    $pdo = null;

}
//14.장바구니 조회
function get_Reserves($userID)
{
    $pdo = pdoSqlConnect();
    $query = "select i.seller_num, i.id,i.image,s.seller_name,i.item_name,i.price,r.option_name
from item as i
join  reserve as r ON i.ID = r.item_num
join seller as s ON s.id = i.seller_num
where r.user_num = ?
";

    $st = $pdo->prepare($query);
    $st->execute([$userID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//15. 장바구니 삭제
function delete_Reserves($userID,$itemID)
{
    $pdo = pdoSqlConnect();
    $query = "delete
from reserve as r
where r.user_num = ? and r.item_num = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userID, $itemID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    //$res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return null; //$res[0];
}

//16.구매목록 생성
function create_Buylist($user_num,$item_num,$createAt,$updateAt,$status,$num,$option_name)
{
    //,$req->seller_num,$req->createAT,$req->updateAt,$req->status
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO buy_list (user_num,item_num,createAt,updateAt,status,num,option_name) VALUES (?,?,?,?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$user_num,$item_num,$createAt,$updateAt,$status,$num,$option_name]);

    $st = null;
    $pdo = null;

}
//17.구매목록 조회
function get_Buylist($userID)
{
    $pdo = pdoSqlConnect();
    $query = "select i.seller_num, i.id,i.image,s.seller_name,i.item_name,i.price,r.option_name
from item as i
join  buy_list as r ON i.ID = r.item_num
join seller as s ON s.id = i.seller_num
where r.user_num = ?
";

    $st = $pdo->prepare($query);
    $st->execute([$userID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

//18. 구매목록 삭제
function delete_Buylist($userID,$itemID)
{
    $pdo = pdoSqlConnect();
    $query = "delete
from buy_list as r
where r.user_num = ? and r.item_num = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userID, $itemID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    //$res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return null; //$res[0];
}

//19.Coupon 생성
function create_Coupon($user_num,$item_num,$createAt,$updateAt,$status)
{
    //,$req->seller_num,$req->createAT,$req->updateAt,$req->status
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO get_coupon (user_num,coupon_num,createAt,updateAt,status) VALUES (?,?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$user_num,$item_num,$createAt,$updateAt,$status]);

    $st = null;
    $pdo = null;

}
//20.Coupon 조회
function get_Coupon($userID)
{
    $pdo = pdoSqlConnect();
    $query = "select g.coupon_num,g.user_num,c.discount,c.coupon_name,c.`shelf life`,c.condition,c.status
from coupon as c
join  get_coupon as g ON c.ID = g.coupon_num
where g.user_num = ?";

$st = $pdo->prepare($query);
$st->execute([$userID]);
//    $st->execute();
$st->setFetchMode(PDO::FETCH_ASSOC);
$res = $st->fetchAll();

$st = null;
$pdo = null;

return $res;
}

//21. Coupon 삭제
function delete_Coupon($userID,$itemID)
{
    $pdo = pdoSqlConnect();
    $query = "delete
from get_coupon as g
where g.user_num = ? and g.coupon_num = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userID, $itemID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    //$res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return null; //$res[0];
}
//22.Comments 생성
function create_Comments($user_num,$item_num,$comment,$image,$createAt,$updateAt,$status)
{
    //,$req->seller_num,$req->createAT,$req->updateAt,$req->status
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO comment (user_num,item_num,comment,image,createAt,updateAt,status) VALUES (?,?,?,?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$user_num,$item_num,$comment,$image,$createAt,$updateAt,$status]);

    $st = null;
    $pdo = null;

}
//23. Comments 조회
function get_Comments($userID)
{
    $pdo = pdoSqlConnect();
    $query = "select c.user_num,c.item_num,c.comment,c.image,c.createAt,c.updateAt,c.status   
from comment as c
where c. item_num = ?";

    $st = $pdo->prepare($query);
    $st->execute([$userID]);
//    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}
//24. comments 삭제
function delete_Comments($userID,$itemID)
{
    $pdo = pdoSqlConnect();
    $query = "delete
from comment as g
where g.user_num = ? and g.item_num = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userID, $itemID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    //$res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return null; //$res[0];
}
//25. 랭킹
function get_Ranks($userID)
{
    $pdo = pdoSqlConnect();
    $query = "select s.id as seller_num, s.image,s.status,count(st.ID)as star
from seller as s
join star as st on st.seller_num = s.id
group by s.id
order by star desc
;";

    $st = $pdo->prepare($query);
    $st->execute([$userID]);
//    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}
//26. 이벤트
function get_Events()
{
    $pdo = pdoSqlConnect();
    $query = "select e.id, e.num,e.image,e.status
from event as e
order by e.num;";

    $st = $pdo->prepare($query);
    $st->execute();
//    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}
//27.최근목록 생성
function create_Recent($user_num,$item_num,$createAt,$updateAt,$status)
{
    //,$req->seller_num,$req->createAT,$req->updateAt,$req->status
    $pdo = pdoSqlConnect();
    $query = "INSERT INTO recent_view (user_num,item_num,createAt,updateAt,status) VALUES (?,?,?,?,?);";

    $st = $pdo->prepare($query);
    $st->execute([$user_num,$item_num,$createAt,$updateAt,$status]);

    $st = null;
    $pdo = null;

}


//29. 구매목록 삭제
function delete_Recent($userID,$itemID)
{
    $pdo = pdoSqlConnect();
    $query = "delete
from recent_view as r
where r.user_num = ? and r.item_num = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$userID, $itemID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    //$res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return null; //$res[0];
}
//no.31 쇼핑몰 상세 API
function get_Mall($mallID)
{
    $pdo = pdoSqlConnect();
    $query = "select s.id, s.seller_name , s.image, s.introduce, count(st.ID) as star
from seller as s
join star as st
on st.seller_num = s.ID
where s.id = ?";

    $st = $pdo->prepare($query);
    $st->execute([$mallID]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}


// CREATE
//    function addMaintenance($message){
//        $pdo = pdoSqlConnect();
//        $query = "INSERT INTO MAINTENANCE (MESSAGE) VALUES (?);";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message]);
//
//        $st = null;
//        $pdo = null;
//
//    }


// UPDATE
//    function updateMaintenanceStatus($message, $status, $no){
//        $pdo = pdoSqlConnect();
//        $query = "UPDATE MAINTENANCE
//                        SET MESSAGE = ?,
//                            STATUS  = ?
//                        WHERE NO = ?";
//
//        $st = $pdo->prepare($query);
//        $st->execute([$message, $status, $no]);
//        $st = null;
//        $pdo = null;
//    }

// RETURN BOOLEAN
//    function isRedundantEmail($email){
//        $pdo = pdoSqlConnect();
//        $query = "SELECT EXISTS(SELECT * FROM USER_TB WHERE EMAIL= ?) AS exist;";
//
//
//        $st = $pdo->prepare($query);
//        //    $st->execute([$param,$param]);
//        $st->execute([$email]);
//        $st->setFetchMode(PDO::FETCH_ASSOC);
//        $res = $st->fetchAll();
//
//        $st=null;$pdo = null;
//
//        return intval($res[0]["exist"]);
//
//    }
