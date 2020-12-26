<?php
require 'function.php';

const JWT_SECRET_KEY = "TEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEYTEST_KEY";

$res = (object)array();
header('Content-Type: json');
$req = json_decode(file_get_contents("php://input"));
try {
    addAccessLogs($accessLogs, $req);
    switch ($handler) {
        case "index":
            echo "API Server1";
            break;
        case "ACCESS_LOGS":
            //            header('content-type text/html charset=utf-8');
            header('Content-Type: text/html; charset=UTF-8');
            getLogs("./logs/access.log");
            break;
        case "ERROR_LOGS":
            //            header('content-type text/html charset=utf-8');
            header('Content-Type: text/html; charset=UTF-8');
            getLogs("./logs/errors.log");
            break;

        case "items_Search":
            http_response_code(200);

            $S_item = $_GET['S_item'];


            $res->result = get_item_search($S_item);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공1";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        case "getUsers":
            http_response_code(200);

            $res->result = getUsers();
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        /*
         * API No. 5
         * API Name : 테스트 Path Variable API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "getUserDetail":

            http_response_code(200);

            $res->result = getUserDetail($vars["userIdx"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        /*
         * API No. 6
         * API Name : 테스트 Body & Insert API
         * 마지막 수정 날짜 : 19.04.29
         */
        case "createUser":
            http_response_code(200);

            // Packet의 Body에서 데이터를 파싱합니다.
            $userID = $req->email;
            $pwd_hash = password_hash($req->password, PASSWORD_DEFAULT); // Password Hash
            $name = $req->name;

            $res->result = create_User($req->name, $req->email, $pwd_hash, $req->phone);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "테스트 성공";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        //---------------------------------------------------------------------------------------
        // api no.4 마이페이지 조회
        case "getMypage":

            $jwt = $_SERVER['HTTP_X_ACCESS_TOKEN'];
            $userIdxInToken = getDataByJWToken($jwt,JWT_SECRET_KEY)->userIdx;
            echo($userIdxInToken);
            echo(1);
            $userIdx = $vars['userID'];
            echo($userIdx);
            if($userIdxInToken != $userIdx){
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 id입니다.1";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }


            if (!isValidUserIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 id입니다.2";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            http_response_code(200);
            $res->result = getMypage($userIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //api no.5 기본 아이템 리스트
        case "items":

            //api no.5(1) 아이템 리스트조회(검색)
            if ($_GET['keyword'] != null) {
                if (!isValiditemIdx($_GET['keyword'])) {
                    $res->isSuccess = False;
                    $res->code = 200;
                    $res->message = "잘못된 제시어 입니다.";
                    echo json_encode($res, JSON_NUMERIC_CHECK);
                    break;
                }
                $res->result = get_item_search($_GET['keyword']);
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if ($_GET['heart'] != null) {
                $res->result = get_heart($_GET['heart']);
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if ($_GET['shop'] != null) {
                $res->result = get_shop($_GET['shop']);
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            http_response_code(200);
            if ($_GET['page'] != null) {
                $res->result = get_items_page($_GET['page']);
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "테스트 성공";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            } else {
                $res->result = get_items();
                $res->isSuccess = TRUE;
                $res->code = 100;
                $res->message = "테스트 성공";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }

        //api no.6 아이템 상세 조회 API
        case "items_Detail":

            http_response_code(200);

            $res->result = get_item_Detail($vars["itemID"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        //api no.7 즐겨찾기 추가
        case "createStar":
            http_response_code(200);

            if (!isValidUserIdx($req->user_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 유저id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidSellerIdx($req->seller_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 판매자id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (isValidStarIdx($req->user_num, $req->seller_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "이미 있는 즐겨찾기입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = create_Star($req->user_num, $req->seller_num, $req->createAt, $req->updateAt, $req->status);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //api no.8 즐겨찾기 조회
        case "getStar":
            $userIdx = $_GET['userID'];
            if (!isValidUserIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidStar_zeroIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "별을 눌러 쇼핑몰 즐겨찾기";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            http_response_code(200);

            $res->result = get_Star($userIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //9.즐겨찾기 삭제 api
        case "deleteStar":
            $userIdx = $_GET['userID'];
            $sellerIdx = $_GET['sellerID'];
            if (!isValidUserIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidStarIdx($userIdx, $sellerIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "존재하지 않는 즐겨찾기입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = delete_Star($userIdx, $sellerIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        //10. 찜 생성 api
        case "createHeart":
            http_response_code(200);

            if (!isValidUserIdx($req->user_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 유저id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValiditemIdx($req->item_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 상품id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (isValidHeartIdx($req->user_num, $req->item_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "이미 있는 찜입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = create_Heart($req->user_num, $req->item_num, $req->createAt, $req->updateAt, $req->status);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //12. 찜 삭제 api
        case "deleteHeart":
            $userIdx = $_GET['userID'];
            $itemIdx = $_GET['itemID'];
            if (!isValidUserIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidHeartIdx($userIdx, $itemIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "존재하지 않는 찜입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = delete_Heart($userIdx, $itemIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //no.13 장바구니 추가 api
        case "createReserves":
            http_response_code(200);

            if (!isValidUserIdx($req->user_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 유저id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValiditemIdx($req->item_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 상품id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (isValidReserveIdx($req->user_num, $req->item_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "이미 있는 장바구니입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = create_Reserves($req->user_num, $req->item_num, $req->createAt, $req->updateAt, $req->status, $req->num, $req->option_name);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //no.14 장바구니 조회 api
        case "getReserves":
            $userIdx = $_GET['userID'];
            if (!isValidUserIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidReserve_zeroIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "장바구니에 담긴 상품이 없어요";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            http_response_code(200);

            $res->result = get_Reserves($userIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //15.장바구니 삭제 api
        case "deleteReserves":
            $userIdx = $_GET['userID'];
            $itemIdx = $_GET['itemID'];
            if (!isValidUserIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidReserveIdx($userIdx, $itemIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "존재하지 않는 찜입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = delete_Reserves($userIdx, $itemIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        //no.16 구매목록 추가 api
        case "createBuylist":
            http_response_code(200);

            if (!isValidUserIdx($req->user_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 유저id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValiditemIdx($req->item_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 상품id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (isValidBuylistIdx($req->user_num, $req->item_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "이미 있는 장바구니입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = create_Buylist($req->user_num, $req->item_num, $req->createAt, $req->updateAt, $req->status, $req->num, $req->option_name);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //no.17 구매목록 조회 api
        case "getBuylist":
            $userIdx = $_GET['userID'];
            if (!isValidUserIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidBuylist_zeroIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "장바구니에 담긴 상품이 없어요";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            http_response_code(200);

            $res->result = get_Buylist($userIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //18.구매목록 삭제 api
        case "deleteBuylist":
            $userIdx = $_GET['userID'];
            $itemIdx = $_GET['itemID'];
            if (!isValidUserIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidBuylistIdx($userIdx, $itemIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "존재하지 않는 장바구니입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = delete_Buylist($userIdx, $itemIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //no.19 Coupon 추가 api
        case "createCoupon":
            http_response_code(200);

            if (!isValidUserIdx($req->user_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 유저id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidCouponIdx($req->item_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 쿠폰id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (isValidGetCouponIdx($req->user_num, $req->item_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "이미 있는 쿠폰입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = create_Coupon($req->user_num, $req->item_num, $req->createAt, $req->updateAt, $req->status);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //no.20 Coupon 조회 api
        case "getCoupon":
            $userIdx = $_GET['userID'];
            if (!isValidUserIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidCoupon_zeroIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "쿠폰에 담긴 상품이 없어요";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            http_response_code(200);

            $res->result = get_Coupon($userIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //21.Coupon 삭제 api
        case "deleteCoupon":
            $userIdx = $_GET['userID'];
            $itemIdx = $_GET['itemID'];
            if (!isValidCouponIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidCouponIdx($userIdx, $itemIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "존재하지 않는 쿠폰입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = delete_Coupon($userIdx, $itemIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
        //no.22 Comments 추가 api
        case "createComments":
            http_response_code(200);

            if (!isValidUserIdx($req->user_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 유저id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValiditemIdx($req->item_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 아이템id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (isValidGetCommentsIdx($req->user_num, $req->item_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "이미 있는 댓글입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = create_Comments($req->user_num, $req->item_num, $req->comments, $req->image, $req->createAt, $req->updateAt, $req->status);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

        //no.23 Comment 조회 api
        case "getComments":
            $userIdx = $_GET['itemID'];
            if (!isValiditemIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 상품id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidComments_zeroIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "쿠폰에 담긴 상품이 없어요";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            http_response_code(200);

            $res->result = get_Comments($userIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;

//24.Comment 삭제 api
        case "deleteComments":
            $userIdx = $_GET['userID'];
            $itemIdx = $_GET['itemID'];
            if (!isValiduserIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 상품id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidCommentsIdx($userIdx, $itemIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "존재하지 않는 댓글입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = delete_Comments($userIdx, $itemIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
//25.랭킹조회
        case "getRanks":

            http_response_code(200);

            $res->result = get_Ranks();
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
//26.이벤트 조회
        case "getEvents":

            http_response_code(200);

            $res->result = get_Events();
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
//no.27 최근목록 추가 api
        case "createRecent":
            http_response_code(200);

            if (!isValidUserIdx($req->user_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 유저id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValiditemIdx($req->item_num)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 상품id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }

            $res->result = create_Recent($req->user_num, $req->item_num, $req->createAt, $req->updateAt, $req->status);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        //29.최근목록 삭제 api
        case "deleteRecent":
            $userIdx = $_GET['userID'];
            $itemIdx = $_GET['itemID'];
            if (!isValidUserIdx($userIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "잘못된 id입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            if (!isValidRecentsIdx($userIdx, $itemIdx)) {
                $res->isSuccess = False;
                $res->code = 200;
                $res->message = "존재하지 않는 최근목록입니다.";
                echo json_encode($res, JSON_NUMERIC_CHECK);
                break;
            }
            $res->result = delete_Recent($userIdx, $itemIdx);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;


        //api no.31 쇼핑몰 상세 API
        case "getMall":
            http_response_code(200);

            $res->result = get_Mall($vars["shopID"]);
            $res->isSuccess = TRUE;
            $res->code = 100;
            $res->message = "";
            echo json_encode($res, JSON_NUMERIC_CHECK);
            break;
    }


} catch (\Exception $e) {
    return getSQLErrorException($errorLogs, $e, $req);
}
