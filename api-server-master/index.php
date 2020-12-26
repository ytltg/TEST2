<?php

require './pdos/DatabasePdo.php';
require './pdos/IndexPdo.php';
require './pdos/JWTPdo.php';
require './vendor/autoload.php';

use \Monolog\Logger as Logger;
use Monolog\Handler\StreamHandler;

date_default_timezone_set('Asia/Seoul');
ini_set('default_charset', 'utf8mb4');

//에러출력하게 하는 코드
error_reporting(E_ALL); ini_set("display_errors", 1);

//Main Server API
$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    /* ******************   JWT   ****************** */
    $r->addRoute('POST', '/jwt', ['JWTController', 'createJwt']);   // JWT 생성: 로그인 + 해싱된 패스워드 검증 내용 추가
    $r->addRoute('GET', '/jwt', ['JWTController', 'validateJwt']);  // JWT 유효성 검사

    /* ******************   Test   ****************** */
    $r->addRoute('GET', '/', ['IndexController', 'index']);
    $r->addRoute('GET', '/users', ['IndexController', 'getUsers']);//유저 정보 전체
    $r->addRoute('GET', '/users/{userIdx}', ['IndexController', 'getUserDetail']); // 유저 상세
    $r->addRoute('POST', '/user', ['IndexController', 'createUser']); // 가입
    $r->addRoute('DELETE', '/user_d', ['IndexController', 'deleteUser']); // 삭제
    //-----------------------------------------여기까지 테스트-----------------------------------
    $r->addRoute('GET', '/user/{userID}', ['IndexController', 'getMypage']); // api no.4 마이페이지 조회

    $r->addRoute('GET', '/items', ['IndexController', 'items']); //api no.5 아이템 리스트
    //$r->addRoute('GET', '/items?keyword', ['IndexController', 'items']); // api no.5(2) 아이템 리스트조회(검색)
    $r->addRoute('GET', '/items/{itemID}', ['IndexController', 'items_Detail']); // api no.6 아이템 상세 조회 API

    $r->addRoute('POST', '/stars', ['IndexController', 'createStar']); // api no.7 즐겨찾기 추가 API
    $r->addRoute('GET', '/stars', ['IndexController', 'getStar']); // api no.8 즐겨찾기 조회 API
    $r->addRoute('DELETE', '/stars', ['IndexController', 'deleteStar']); // api no.9 즐겨찾기 삭제 API

    $r->addRoute('POST', '/hearts', ['IndexController', 'createHeart']); // api no.10 찜 추가 API
    //$r->addRoute('GET', '//items?heart=true', ['IndexController', 'items']); // api no.5(2) 찜 조회 API
    $r->addRoute('DELETE', '/hearts', ['IndexController', 'deleteHeart']); // api no.12 찜 삭제 API

    $r->addRoute('POST', '/reserves', ['IndexController', 'createReserves']); // api no.13 장바구니 추가 API
    $r->addRoute('GET', '/reserves', ['IndexController', 'getReserves']); // api no.14 장바구니 조회 API
    $r->addRoute('DELETE', '/reserves', ['IndexController', 'deleteReserves']); // api no.15 장바구니 삭제 API

    $r->addRoute('POST', '/buylist', ['IndexController', 'createBuylist']); // api no.16 구매목록 추가 API
    $r->addRoute('GET', '/buylist', ['IndexController', 'getBuylist']); // api no.17 구매목록 조회 API
    $r->addRoute('DELETE', '/buylist', ['IndexController', 'deleteBuylist']); // api no.18 구매목록 삭제 API

    $r->addRoute('POST', '/coupons', ['IndexController', 'createCoupon']); // api no.19 쿠폰 추가 API
    $r->addRoute('GET', '/coupons', ['IndexController', 'getCoupon']); // api no.20 쿠폰 조회 API
    //$r->addRoute('GET', '/coupons?del', ['IndexController', 'getCoupons']); // api no.20(1) 다쓴 쿠폰 조회 API
    $r->addRoute('DELETE', '/coupons', ['IndexController', 'deleteCoupon']); // api no.21 쿠폰 삭제 API

    $r->addRoute('POST', '/comments', ['IndexController', 'createComments']); // api no.12 댓글 추가 API
    $r->addRoute('GET', '/comments', ['IndexController', 'getComments']); // api no.23 댓글 조회 API
    $r->addRoute('DELETE', '/comments', ['IndexController', 'deleteComments']); // api no.24 댓글 삭제 API

    $r->addRoute('GET', '/ranking', ['IndexController', 'getRanks']); // api no.25 쇼핑몰 랭킹 API
    $r->addRoute('GET', '/events', ['IndexController', 'getEvents']); // api no.26 이벤트 API

    $r->addRoute('POST', '/recents', ['IndexController', 'createRecent']); // api no.27 최근목록 추가 API
    //$r->addRoute('GET', '/comments', ['IndexController', 'getComments']); // api no.28 댓글 조회 API
    $r->addRoute('DELETE', '/recents', ['IndexController', 'deleteRecent']); // api no.29 최근목록 삭제 API

    $r->addRoute('GET', '/mall/{shopID}', ['IndexController', 'getMall']); // api no.31 쇼핑몰 상세
    $r->addRoute('GET', '//items?shop=true', ['IndexController', 'items']); // api no.5(3) 쇼핑몰 물품 조회
//    $r->addRoute('GET', '/users', 'get_all_users_handler');
//    // {id} must be a number (\d+)
//    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
//    // The /{title} suffix is optional
//    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

// 로거 채널 생성
$accessLogs = new Logger('ACCESS_LOGS');
$errorLogs = new Logger('ERROR_LOGS');
// log/your.log 파일에 로그 생성. 로그 레벨은 Info
$accessLogs->pushHandler(new StreamHandler('logs/access.log', Logger::INFO));
$errorLogs->pushHandler(new StreamHandler('logs/errors.log', Logger::ERROR));
// add records to the log
//$log->addInfo('Info log');
// Debug 는 Info 레벨보다 낮으므로 아래 로그는 출력되지 않음
//$log->addDebug('Debug log');
//$log->addError('Error log');

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo "404 Not Found";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "405 Method Not Allowed";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        switch ($routeInfo[1][0]) {
            case 'IndexController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/IndexController.php';
                break;
            case 'JWTController':
                $handler = $routeInfo[1][1];
                $vars = $routeInfo[2];
                require './controllers/JWTController.php';
                break;
            /*case 'EventController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/EventController.php';
                break;
            case 'ProductController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/ProductController.php';
                break;
            case 'SearchController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/SearchController.php';
                break;
            case 'ReviewController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/ReviewController.php';
                break;
            case 'ElementController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/ElementController.php';
                break;
            case 'AskFAQController':
                $handler = $routeInfo[1][1]; $vars = $routeInfo[2];
                require './controllers/AskFAQController.php';
                break;*/
        }

        break;
}
