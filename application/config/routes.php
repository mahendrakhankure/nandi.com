<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/*

| -------------------------------------------------------------------------

| URI ROUTING

| -------------------------------------------------------------------------

| This file lets you re-map URI requests to specific controller functions.

|

| Typically there is a one-to-one relationship between a URL string

| and its corresponding controller class/method. The segments in a

| URL normally follow this pattern:

|

|	example.com/class/method/id/

|

| In some instances, however, you may want to remap this relationship

| so that a different class/function is called than the one

| corresponding to the URL.

|

| Please see the user guide for complete details:

|

|	https://codeigniter.com/user_guide/general/routing.html

|

| -------------------------------------------------------------------------

| RESERVED ROUTES

| -------------------------------------------------------------------------

|

| There are three reserved routes:

|

|	$route['default_controller'] = 'welcome';

|

| This route indicates which controller class should be loaded if the

| URI contains no data. In the above example, the "welcome" class

| would be loaded.

|

|	$route['404_override'] = 'errors/page_missing';

|

| This route will tell the Router which controller/method to use if those

| provided in the URL cannot be matched to a valid route.

|

|	$route['translate_uri_dashes'] = FALSE;

|

| This is not exactly a route, but allows you to automatically route

| controller and method names that contain dashes. '-' isn't a valid

| class or method name character, so it requires translation.

| When you set this option to TRUE, it will replace ALL dashes in the

| controller and method URI segments.

|

| Examples:	my-controller/index	-> my_controller/index

|		my-controller/my-method	-> my_controller/my_method

*/

// $this->set_directory( "admin" );

$route['default_controller'] = "Welcome";

$route['404_override'] = 'error_404';

$route['translate_uri_dashes'] = FALSE;



$route['about'] = 'home/about';

$route['howToPlay'] = 'home/howToPlay';

$route['testimonial'] = 'home/testimonial';

$route['faq'] = 'home/faq';

$route['terms-and-condition'] = 'home/termscondition';

$route['refund-policy'] = 'home/refundpolicy';

$route['privacy-policy'] = 'home/privacypolicy';

$route['contact-us'] = 'home/contactus';

$route['8c444c53b0d75dab10ebb5ceb640e5c2'] = 'User/RegularMarket';



$route['myhouse'] = "login";

/*********** USER DEFINED ROUTES *******************/



// $route['loginMe'] = 'login/loginMe';

// $route['dashboard'] = 'user';

// $route['logout'] = 'user/logout';

// $route['userListing'] = 'user/userListing';

// $route['userListing/(:num)'] = "user/userListing/$1";

// $route['addNew'] = "user/addNew";

// $route['addNewUser'] = "user/addNewUser";

// $route['editOld'] = "user/editOld";

// $route['editOld/(:num)'] = "user/editOld/$1";

// $route['editUser'] = "user/editUser";

// $route['deleteUser'] = "user/deleteUser";

// $route['profile'] = "user/profile";

// $route['profile/(:any)'] = "user/profile/$1";

// $route['profileUpdate'] = "user/profileUpdate";

// $route['profileUpdate/(:any)'] = "user/profileUpdate/$1";



// $route['loadChangePass'] = "user/loadChangePass";

// $route['changePassword'] = "user/changePassword";

// $route['changePassword/(:any)'] = "user/changePassword/$1";

// $route['pageNotFound'] = "user/pageNotFound";

// $route['checkEmailExists'] = "user/checkEmailExists";

// $route['login-history'] = "user/loginHistoy";

// $route['login-history/(:num)'] = "user/loginHistoy/$1";

// $route['login-history/(:num)/(:num)'] = "user/loginHistoy/$1/$2";



// $route['forgotPassword'] = "login/forgotPassword";

// $route['resetPasswordUser'] = "login/resetPasswordUser";

// $route['resetPasswordConfirmUser'] = "login/resetPasswordConfirmUser";

// $route['resetPasswordConfirmUser/(:any)'] = "login/resetPasswordConfirmUser/$1";

// $route['resetPasswordConfirmUser/(:any)/(:any)'] = "login/resetPasswordConfirmUser/$1/$2";

// $route['createPasswordUser'] = "login/createPasswordUser";



/* End of file routes.php */

/* Location: ./application/config/routes.php */

/*********** IFRAME ROUTES *******************/


$route['signup'] = "Welcome/login";
$route['signout'] = "Welcome/logout";



// $route['login'] = "admin/login/index";
$route['login'] = "error_404";
$route['95dfb6e273f059ca76e2e35750819ed3'] = "admin/login/index";
$route['1828962beb83c30f2541d601ea2b4251a'] = "admin/login/otp";
$route['7920b45e2ed3e9257e1bb7c00272e957'] = "admin/login/announcer_login";
$route['40be4e59b9a2a2b5dffb918c0e86b3d7'] = "Welcome/index";

$route['3da0a580df58737ae1a3adebdcf5dbab'] = 'User/RegularMarket/homePageNew';

$route['RegularMarket/PlaceBets'] = 'User/RegularMarket/PlaceBets';
$route['8c444c53b0d75dab10ebb5ceb640e5c2'] = 'User/RegularMarket/index';
$route['69ecdc47fabe19d06aace6dffda686cd'] = 'User/StarlineMarket/index';
$route['560e830fd37dab699c0c991bbc94a1c1'] = 'User/KingMarket/index';

$route['88c15c33ba8e74577362640d9eee008e/(:any)'] = 'User/KingMarket/kingAutoResult/$1';

$route['9c8f59a017280083c64fbc7e958e590f/(:any)'] = 'User/KingMarket/kingGameList/$1';
$route['b53e70fa24904d94988757105672a5e0/(:any)/(:any)'] = "User/StarlineMarket/GameTimeList/$1/$2";
$route['627c9e487ce67279be0ba390dbbf2735/(:any)/(:any)/(:any)'] = "User/StarlineMarket/StarlineGameTypeList/$1/$2/$3";
$route['e534e7037142e159782e361529634c32/(:any)/(:any)'] = "User/StarlineMarket/getStarlineResultByPercentage/$1/$2";
$route['e534e7037142e159782e361529634c32123/(:any)'] = "User/StarlineMarket/getKingBazarResultByPercentage/$1";

$route['793182a22eb287c890ebb602c4243120/(:any)/(:any)'] = "User/StarlineMarket/starAutoResult/$1/$2";

$route['5bfdc27f43fb4f5d76b0028e908b64a4/(:any)/(:any)'] = "User/KingMarket/betsOnGame/$1/$2";
$route['679a6a3e6bad2fa0fcc51a272283a9d9'] = "User/KingMarket/PlaceBetsKing";

$route['d04cd65a193d25064eb7375b799adc29/(:any)/(:any)/(:any)'] = "User/StarlineMarket/betsOnGame/$1/$2/$3";
$route['36b3c7870f6be4f9ff75cb513bd18f8f'] = "User/StarlineMarket/PlaceBets";

$route['9a27a7e97c16a7b3ac6382d21205357f121212'] = "User/RegularMarket/testForSoketTest";


$route['testWelcome'] = "Welcome/testWelcome";
$route['9a27a7e97c16a7b3ac6382d21205357f/(:any)/(:any)'] = "User/RegularMarket/GameTypeList/$1/$2";
$route['2f7b8019e658ea93b1e4d76ac4c6096f/(:any)/(:any)/(:any)'] = "User/RegularMarket/betsOnGame/$1/$2/$3";
$route['5d28279d2fbc52cd3d81275f5a65ae0e'] = "User/RegularMarket/PlaceBets";
$route['e6e9a4f45aa1534488f516530c534059'] = "admin/Manage_Matkaallgames/updateWallet";
$route['d50323af60643ba9e1da40d643c44966'] = "admin/Manage_Starlinegameallresult/updateWalletStar";
$route['7ae7165a06ebd76c2c5ee3d24213805e'] = "admin/Manage_Kingbazarallresult/updateWalletKing";


$route['de42a3f3870e91622ccb9c71af924f19'] = "admin/Manage_Matkagames/changePassword";
$route['cb5ef3113af9fe69edca229f43c878ec'] = "admin/Manage_Matkaallgames/regularMarketBetRecords";
$route['f14c46a21b8f8c33edb09b186406c8ba/(:any)/(:any)'] = "admin/Manage_Matkaallgames/regularTypeRecords/$1/$2";
$route['b1890aff64350052e514fad93e39fc3e/(:any)/(:any)'] = "admin/Manage_Matkaallgames/regularGameRecords/$1/$2";
$route['48dcc5c6511a02fd2229d34703910a24'] = "admin/Manage_Matkaallgames/backBusiness";
$route['59857792564e7b27ecd66c6570acd845/(:any)/(:any)'] = "admin/Manage_Matkaallgames/regularTypeRecordsBackBusiness/$1/$2";
$route['b71c70d91e49a65ede30de4102aea45a/(:any)/(:any)/(:any)/(:any)'] = "admin/Manage_Matkaallgames/regularBetsDetailBackBusiness/$1/$2/$3/$4";


$route['5b219095e82147b46456272433496446'] = "admin/Manage_Starlinegames/backBusinessStarline";
$route['94bfdb1790a9084227983742ede72196/(:any)/(:any)'] = "admin/Manage_Starlinegames/starlineMarketTimeBetRecordsBackBusiness/$1/$2";
$route['830df9ac2093a820a7db63c85f46303f/(:any)/(:any)/(:any)'] = "admin/Manage_Starlinegames/starlineMarketTypeRecordsBackBusiness/$1/$2/$3";
$route['10c7e46ff7aa9a9d9b335b091d4f2dd3/(:any)/(:any)/(:any)/(:any)/(:any)'] = "admin/Manage_Starlinegames/starlineMarketGameRecordsBackBusiness/$1/$2/$3/$4/$5";


$route['24a61b8dcaa54223fff747ea2c6fb72d'] = "admin/Manage_Kingbazargames/backBusinessKing";
$route['5ede4511d6734c99318abcd84ea332eb/(:any)/(:any)'] = "admin/Manage_Kingbazargames/kingGameTypeListBackBusiness/$1/$2";
$route['1997a99c1b8b89695a25211764b9e7e1/(:any)/(:any)/(:any)'] = "admin/Manage_Kingbazargames/kingGameRecordBackBusiness/$1/$2/$3";

$route['2b22e4966c6c27677713efe0a012e190'] = "admin/Manage_Matkaallgames/regularMarketPendingBetRecords";


$route['ea6f993d7d823816d85299977da11f45'] = "admin/Manage_Matkaallgames/tabsData";
$route['ad7c4ca6c28dcbed88f64d3bb1875637'] = "admin/Manage_Matkaallgames/tabsDataBackBusiness";

$route['bc0e5c2a1b60667c665944ed13a47e4b'] = "admin/Manage_Starlinegames/starlineMarketBetRecords";
$route['b4ffb330bdc320c0a7e29e6d251fbccb/(:any)/(:any)'] = "admin/Manage_Starlinegames/starlineMarketTimeBetRecords/$1/$2";
$route['7bec85cdcef85df6822179a95c64b80f/(:any)/(:any)/(:any)'] = "admin/Manage_Starlinegames/starlineMarketTypeRecords/$1/$2/$3";
$route['e8403aadfc2add778d1d778245c5f25b/(:any)/(:any)/(:any)/(:any)/(:any)'] = "admin/Manage_Starlinegames/starlineMarketGameRecords/$1/$2/$3/$4/$5";

$route['fb8cea741f03e6ba2d5c7b90b8657500'] = "admin/Manage_Starlinegames/starlineBetDetail";



$route['a429d046df97a54547ae9f9b523bb904'] = "admin/Manage_Matkagames/regularBazarList";
$route['0f32a616f35638d4e0b44c9ab643976e/(:any)'] = "admin/Manage_Matkagames/addNewBazar/$1";
$route['ac947e65b4985f0215ded1582c2ef6cd'] = "admin/Manage_Matkagames/bazarRateList";
$route['fe51185ebf4796c15924a4d75baef204/(:any)'] = "admin/Manage_Matkagames/addNewBazarRate/$1";
$route['495422a2a9c4fef025803d9180abc03b'] = "admin/Manage_Matkagames/GameTypeList";
$route['ddfe6e4d6d774310c1034abfdd29c30d/(:any)'] = "admin/Manage_Matkagames/addNewGameType/$1";

$route['7932304afa07498c9b2b9cd3954c33d7'] = "admin/Manage_Starlinegames/bazarList";
$route['3afbe93779c63a141c07aa38bc717dad/(:any)'] = "admin/Manage_Starlinegames/addNewBazar/$1";
$route['0b1a4cf7c60a831e444002c6fdde6f8f'] = "admin/Manage_Starlinegames/bazarTimeList";
$route['77ea0d27f166c8231ec4a9a0861af552/(:any)'] = "admin/Manage_Starlinegames/addNewBazarTime/$1";
$route['bc81603a6bb850328fa301e58be072ed'] = "admin/Manage_Starlinegames/bhavList";
$route['5799688ce86ca0aeee3a5db6e27dae22/(:any)'] = "admin/Manage_Starlinegames/addNewBhav/$1";
$route['bc5b398327e1377d15fb309a07d92e8b'] = "admin/Manage_Starlinegames/gameTypeList";
$route['79046094d59e745770a92655779e6284/(:any)'] = "admin/Manage_Starlinegames/addNewGameType/$1";


$route['239ef3437609e5a9ae1795724cfcbe92'] = "admin/Manage_Kingbazargames/bazarRateList";
$route['795fe65fb3eeb88fa7310a56502afbff/(:any)'] = "admin/Manage_Kingbazargames/addNewBazarRate/$1";
$route['e2fcdfc449fc439efc025b14edb93cb3'] = "admin/Manage_Kingbazargames/BazarList";
$route['99c6186ebf490c7e3aac5eb4fac20c32/(:any)/(:any)'] = "admin/Manage_Kingbazargames/kingGameTypeList/$1/$2";
$route['c1881587b76a7f53805cae24277e5aa5/(:any)/(:any)/(:any)'] = "admin/Manage_Kingbazargames/kingGameRecord/$1/$2/$3";

$route['d383679f6c7f94714026d747f9f77f33'] = "admin/Manage_Matkagames/bazarBackBusiness";
$route['22c7b3b5d58876cf203a6a09dd70401a'] = "admin/Manage_Matkagames/bazarBackBusinessByCustomer";
$route['8d37bb5635b7b6b13fea292d485a7765'] = "admin/Manage_Matkagames/bazarBackBusinessByCustomerStar";
$route['a29b052d4c3bd98b0357f56934d6460d'] = "admin/Manage_Matkagames/bazarBackBusinessByCustomerKing";
$route['d3454bbf95ce2d44beee1693f52815c1'] = "admin/Manage_Matkagames/bazarBackBusinessByCustomerWorli";
$route['c5b1c5c42325ab0120d776f1961dd4df'] = "admin/Manage_Matkagames/riskPlayer";



$route['6060624ec45717af91f2e27378e83ed2'] = "admin/Manage_Matkagames/worliRoundResult";
$route['eb1c2c7a0179400c52ba3dceea05037b'] = "admin/Manage_Matkagames/changeWorliRoundStatus";
$route['88c6f52a96587d4580b6301082e68c94'] = "admin/Manage_Matkagames/addWorliResultByAdmin";


$route['85b1d2982c1e9a4d4a489247d6e92834'] = "admin/Manage_Matkagames/worliRoundStatment";
$route['635ca881874e8997fbb4bd0ee706a6b0'] = "admin/Manage_Matkagames/blueTableRoundStatment";
$route['d6afe43edc4aa569bd3252c63674c690'] = "admin/Manage_Matkaallgames/regularRoundStatment";
$route['8c0faee552eeb7951884cbae301e4030'] = "admin/Manage_Matkaallgames/regularRoundStatmentData";
$route['aaaca16a7669672bc7f438c88c9432cf'] = "admin/Manage_Matkaallgames/getBazarResult";


$route['4afb875daabfd071a2818c10852a3928'] = "admin/Manage_Matkaallgames/segricatedRegularRoundStatmentNew"; // new buffer option for regular market 

$route['a63973b181b0c52cf1e74629fc6d50ff'] = "admin/Manage_Matkaallgames/segricatedRegularRoundStatment";
$route['ba12cb7f1e10a13d014c07c9c37a1e9c'] = "admin/Manage_Matkaallgames/segricatedRegularRoundStatmentData";
$route['20957dcc477ff123890ec02233ed3f2f'] = "admin/Manage_Matkaallgames/addCutting";
$route['f80d15e4e53ed623b385a4b62b1cef38'] = "admin/Manage_Matkaallgames/cuttingRecord";

$route['2aefee78dca1a4a40b110f5694960d8b'] = "admin/Manage_Matkaallgames/pnlBetween";
$route['2b8c2d994a9278e1ba9e5550010d77f2'] = "Manage_Globles/ClientList";
$route['534deb2130b02322d84f24d0e7af5c55/(:any)'] = "Manage_Globles/addNewClient/$1";


$route['462dad51418ceb8ba9d4d7972da579ec'] = "client/ClientLogin/login";
$route['636787766b8a13835883e0ffd0b04831'] = "client/ClientLogin/logout";
$route['4772d54d262235a418ec16f4c0686614'] = "client/ClientPanel/dashboard";
$route['4c0958082ad28b171c7888d8c9846c95'] = "client/ClientPanel/pnlBetween";

$route['f3a7275951dd09b89653d89795236be5'] = "client/ClientPanel/regularBazar";
$route['240e069c4655784db0c2891ba9e572e6'] = "client/ClientPanel/starBazar";
$route['b88925d66502df355942bc72e0d67a62'] = "client/ClientPanel/kingBazar";

$route['b8fbf0c6a442d7d8b687cb8585938131'] = "User/RegularMarket/marketBhav";
$route['08f76ac8582bfa4e9e9e18a23a75e8e1'] = "admin/Manage_Matkagames/instantWorliBhavList";
$route['c0f99ce7c672fce5b28184cffd977db8'] = "admin/Manage_Matkagames/instantWorliBhavData";
$route['319476fefe4a8968d245a8cef43ebee2'] = "admin/Manage_Matkagames/updateWorliBhav";
$route['34642c7cc851bdfd6834b7940e59026e'] = "admin/Manage_Matkagames/instantWorliResultList";

$route['fde1bddc62c5b0a9494afcfff7676e97'] = "admin/Manage_WorliBazar/redTableBhavList";
$route['8faca56e342dd1e7d5deb2d2df3d27fb'] = "admin/Manage_WorliBazar/redTableBhavData";
$route['3813dc5521288f7693e5ba4132fd44d1'] = "admin/Manage_WorliBazar/redTableBhav";
$route['5816f6eadaea1ccb550214321748aa7d'] = "admin/Manage_WorliBazar/redTableResultList";

$route['49eef90ad0722ab54d478353bc7e0cfb'] = "admin/Manage_WorliBazar/goldenTableBhavList";
$route['7193d2ee7ca9a6ba52e0dfc4e6e83f4d'] = "admin/Manage_WorliBazar/goldenTableBhavData";
$route['0ebc829f4780fdd7ea89a4be1b8e41f9'] = "admin/Manage_WorliBazar/goldenTableBhav";
$route['e4d81e8a2e862b27b97d6e93c5878c54'] = "admin/Manage_WorliBazar/goldenTableResultList";
$route['242e20696e8ccf521304bafa25deba4e'] = "admin/Manage_WorliBazar/winnerList";

$route['f8ae0c9c3c9747d5ebe48e99a257dea7/(:any)'] = "User/RegularMarket/usersHistory/$1";

$route['3ae43540be62a1c9e3c8a5420a09e07f'] = "User/RegularMarket/getUserHistory";

$route['45985ee2c0322111323ce1c8013fbb7c'] = "User/RegularMarket/resultRequest";

$route['5e39d48aaf6555df5994321389942a16'] = "User/RegularMarket/strimingResult";
$route['00e3219d7bca5968d8f7b24854070195'] = "User/RegularMarket/checkBalance";

$route['4ad7b357b4a728f18d6e27dea29a071e'] = "User/InstantWorli";
$route['73b214954136fa533e3b9f1c9c7833f0'] = "User/InstantWorli/instantWorliStrimingApi";
$route['0d8db88c3368c9fe8cfe903ba42c8b13'] = "User/InstantWorli/PlaceBets";
$route['de2747cd14c59e90e13aa2e40393936d'] = "User/InstantWorli/resultInstantWorli";
$route['af8a5002bdaeb9a4d17b8e1676aceca3'] = "User/InstantWorli/checkStrimStatus";
$route['d22e6d9a374680c5deecbc33f514e652/(:any)'] = "User/InstantWorli/worliHistory/$1";
$route['d22e6d9a374680c5deecbc33f514e662/(:any)'] = "User/InstantWorli/lastWorliResults/$1";

// $route['ad88d0a75362510fba9929d79a6438d6'] = "User/InstantWorli/lastRedTableResults";
// $route['64603c4dce60a6cfbaf081641f438024'] = "User/InstantWorli/lastGoldenTableResults";
$route['64603c4dce60a6cfbaf081641f438024'] = "User/RedTable/updateCommission";

$route['fd4c7ff1732d564d0f412461c4795af8'] = "admin/Manage_Matkaallgames/updatePending";
$route['ec516ad04cf15b3a7c32a132c187f006'] = "admin/Manage_Kingbazarallresult/updatePending";
$route['f4ef46e12f8b9f9b7bfc2bddd832080a'] = "admin/Manage_Starlinegameallresult/updatePending";

$route['61e244a8b1f70b8dc67e4014eb9bc963'] = "User/RedTable";
$route['77c95faa4fc09d86eb2b83663b42e692'] = "User/RedTable/PlaceBets";
$route['a042e1213a78a8c3b1a657803bbb5d36'] = "User/RedTable/checkStrimStatusRedTable";
$route['2149aad4dc6e977113a64ed7aa0e7862'] = "User/RedTable/resultRedTable";

$route['2b7f44ca6739f139405e54e532b74200'] = "User/GoldenTable";
$route['40488a2c4347decb77f662843b126dab'] = "User/GoldenTable/PlaceBets";
$route['2f4c93368e9c77d47db4774af504ddfd'] = "User/GoldenTable/checkStrimStatusGoldenTable";
$route['11f3dc7297223908302bb79f2641e045'] = "User/GoldenTable/resultGoldenTable";


$route['b61f5c1def0540c5dd1b6e2bb0787986'] = "admin/Manage_Matkagames/regularMarketBetList";
$route['42f91b81db7ca9bfa8a6d411d64b248c'] = "admin/Manage_Matkagames/dataRegular";
$route['5e2166103d8c6d0514466533c633e35d'] = "admin/Manage_Matkagames/starlineMarketBetRecords";
$route['0b7b0e682049a1de334771eda98ad759'] = "admin/Manage_Matkagames/dataStarline";
$route['651772891eada9a008917427f34f6d4f'] = "admin/Manage_Matkagames/kingMarketBetRecords";
$route['9416e9c7c9bb76804d484a8e21c269d8'] = "admin/Manage_Matkagames/dataKing";
$route['dc7b83839eaf36e8dd2380106538fdc6'] = "admin/Manage_Matkagames/voidBet";
$route['97175c5a0a1655cf9b87c9cebce721ef'] = "admin/RegularMarket/voidBet";
$route['5836344e5695fa73e26a41f9ef7931d8'] = "admin/InstantWorli/canceledRound";

$route['0014fbc9f53bc70c4ae5f9d47aa2b5c9'] = "admin/Manage_Matkagames/worliMarketBetRecords";
$route['294cc2067a07792a6e1282138e3bdaee'] = "admin/Manage_Matkagames/dataWorli";
$route['2e02d8735758cba49091c857f7917fa4'] = "admin/Manage_Matkagames/blrWorli";
$route['a12d4048968d8a6e14c323cff3180c97'] = "admin/Manage_Matkagames/addWorliResult";
$route['02acba6322d212c923e5093dca48055b'] = "admin/Manage_Matkagames/blrRegular";
$route['9f38ae5f654182b8b4192eb414be21d9'] = "admin/Manage_Matkagames/blrRegularNew";
$route['33e5297a14f36c67dffc9de09970384a'] = "admin/Manage_Matkagames/setPatti";

$route['5be215a5f3a02677a1ccbd36b481bd1d'] = "admin/Manage_Matkagames/setPattiNew";
$route['d0766a376187e9be133972bb682c266d'] = "admin/Manage_Matkagames/setVideo";
$route['d2e99d93a56c1e1263c5714f1729084f'] = "admin/Manage_Matkagames/addRegularResult";
$route['e78040d41159a2b2143250b07eff78ac/(:any)'] = "admin/Manage_Matkagames/addStrimingVideo/$1";
$route['29c84e979cf8e713d94bf77a3cdba080'] = "admin/Manage_Matkagames/videoStrimingList";

$route['1b7688d1678b1a77de4951b40301b4b4'] = "admin/Manage_Matkagames/getWorliRoundBets";
$route['ca9c9e1a461385a12cda04c779f16d9a'] = "admin/Manage_Matkagames/topPlayers";


$route['a5f7fb478501800fd4809dba0457b3f8'] = "admin/Manage_WorliBazar/redTableBetRecords";
$route['485e3801e1b7984fedba6173dad08c3b'] = "admin/Manage_WorliBazar/dataRedTable";

$route['638d33c008cb5bd15e689fe963393ccb'] = "admin/Manage_WorliBazar/goldenTableBetRecords";
$route['0c3a8cbdb8e057f760cd16f90047d697'] = "admin/Manage_WorliBazar/dataGoldenTable";


$route['bb4a1bc110d4a919e3fd660f0bdffb41'] = "admin/Manage_Matkagames/blrBlueTable";
$route['e33991c5a6ae3cc80cd8ec83d8584295'] = "admin/Manage_Matkagames/addBlueTableResult";


$route['0dd506e396bf18ea8798d354bb9acd6f'] = "admin/Manage_Matkagames/lastActivity";
$route['f2356c74eddd4a15682b144eaacb3071'] = "admin/Manage_Matkagames/regularMarketResultRecords";
$route['0c57f9f166bd090aa1e47fae7ee93a96'] = "admin/Manage_Matkagames/dataRegularResult";
$route['721466737f6712c1f81542599265fd77'] = "admin/Manage_Matkagames/kingMarketResultRecords";
$route['36481284d96d48642e9e9a683c46a0fe'] = "admin/Manage_Matkagames/dataKingResult";
$route['086a938697cd6feb6d062e6fd0c5c845'] = "admin/Manage_Matkagames/starlineMarketResultRecords";
$route['0fead7315f135c6b3d8f6846e3324c15'] = "admin/Manage_Matkagames/dataStarlineResult";
$route['5e1e2ea84d99f30fb324ceb6c034583e'] = "User/InstantWorli/worliSetalment";

$route['70fed1623f9897a31ac8a6e50023cc58'] = "admin/Manage_Matkagames/resetalmentBets";

$route['fa3f22e952b82786ee43dedb66969556/(:any)'] = "admin/Manage_Matkaallgames/rollBackResult/$1";
$route['e7c0c0ac654bb6980952235a04ffe26e/(:any)'] = "admin/Manage_Starlinegames/rollBackResult/$1";
$route['c1668013ed412d2d15dccf04fc362c96/(:any)'] = "admin/Manage_Kingbazargames/rollBackResult/$1";

$route['bd29495a162eff20974745d93895b1fa/(:any)/(:any)/(:any)/(:any)'] = "admin/Manage_Matkaallgames/regularBetsDetail/$1/$2/$3/$4";
$route['2244fceab338c33fa726834ce8a652a3'] = "admin/Manage_Matkaallgames/regularBetsListGameType";

$route['673d1219093f544ecc33e3d3c85f069c'] = "admin/Manage_Matkaallgames/outMarketPattiCutting";
$route['f475344d3c18a6b3a211b4fed6f12458'] = "admin/Manage_Matkaallgames/customerList";
$route['d7ddb6f2c724eb31ec676b5a2b8ee3ba'] = "admin/Manage_Matkaallgames/todaysPlayerList";
$route['762a1c6be55b9a89fceffe61a6666aa2'] = "admin/Manage_Matkaallgames/addCustomerRate";
$route['e2392d2c34003606d9478ac36e766e34'] = "admin/Manage_Matkaallgames/listCustomerRate";
$route['b045f201f68498c76b8fae94c1081e2d'] = "admin/Manage_Matkaallgames/customerRateData";
$route['22d990b4b5ec7daecccce10725ac9db3'] = "admin/Manage_Matkaallgames/changeCustomerData";
$route['ea8121ad3617938478e90e8a81a1b058'] = "admin/Manage_Matkaallgames/outMarketCutting";
$route['4f5cc6d9d04718c0705f232595e1ab98'] = "admin/Manage_Matkaallgames/outMarketCuttingData";

$route['1b490b4efaaeab4a7e0185d0c71389b7'] = "admin/Manage_Matkaallgames/changeCutting";

$route['99e5e8bcc18ef557c15876675bf8e7e6'] = "User/InstantWorli/testsoket";
// $route['99e5e8bcc18ef557c15876675bf8e7e6'] = "User/InstantWorli/test";
// $route['349d83014cb89afe429b9745fe2c2a6e/(:any)/(:any)/(:any)'] = "User/RegularMarket/resultPanel/$1/$2/$3";

// For API
$route['9e0fac7b4f9149e24f7a6fe80baa8180'] = "User/RegularMarket/ApiBazarList";
$route['501d9a555eb510f68e1e91a75adbd92e/(:any)/(:any)'] = "User/RegularMarket/getResultByCron/$1/$2";
$route['5a476c1a3dc6989c351a130f502b1355'] = "User/RegularMarket/settleBets";  //resetalment api for client
// $route['5a476c1a3dc6989c351a130f502b1355'] = "User/RegularMarket/getJson";
$route['f4993364a3d838b4174d4a40bd82604f'] = "admin/Manage_Matkagames/getStrimingResult";
// For testing perpost 

$route['88a48415068cd9f937e30d3f38e67e71'] = "User/RegularMarket/strimingResultForTesting";

$route['5f99636af6d3efaee3b4b7750bb88640'] = "User/RegularMarket/loopResult";
$route['af8b6f712deb5f8c8b38dc378c3f76c4'] = "User/RegularMarket/getResultDataForIframe";
$route['86bcdbc6e755bc444b4c82e1717e6fee'] = "User/RegularMarket/loopResultStarline";
$route['3dd82e1d2631016967cadeae972f0955'] = "User/RegularMarket/getResultDataForIframeStarline";
$route['dd0494b3caea7b4695b86d35af0059d2'] = "User/RegularMarket/loopResultKing";
$route['33f83de1eb0bd86f1fc1ba49b00b8fd5'] = "User/RegularMarket/getResultDataForIframeKing";

$route['testMCript/(:any)'] = "User/InstantWorli/testMCript/$1";

$route['6d672c14ad6348f4154754d0f5fda34b'] = "User/InstantWorli/worliSetalment";
// $route['6d672c14ad6348f4154754d0f5fda34b'] = "User/InstantWorli/resultInstantWorliBk";

$route['168268b3ad6d52f3fb7171e21d4e3d0e'] = "User/InstantWorli/testInstantWorli";

$route['a8bce2aae048fc8db242be976e42a1e7'] = 'User/KingMarket/maintenance';

$route['250130c21dbbd5247d6f38fac054ba64'] = 'User/RegularMarket/kingList';


// Crown Jobs
$route['87bf6fb0167a770ade4b74d0c275f681'] = 'User/InstantWorli/worliSetalmentCrownJob';
$route['dc2f112965e98c3acd78bfad5261438f'] = 'User/RegularMarket/getTokenDetail';
$route['7640877e24505619481d6fe777ac261a/(:any)/(:any)'] = 'User/InstantWorli/worliResetalmentCrownJob/$1/$2';

$route['9672236fce4fbd5d72bdef16c13182f7/(:any)/(:any)'] = 'User/RegularMarket/autoStrimingResult/$1/$2';
$route['f2b944daf2e1472ddf6cb0c5f3c8431b'] = 'User/RegularMarket/stopBuffer';


$route['e2392d2c34003606d9478ac36e766e40'] = "admin/Holidays/marketHolidays";
$route['762a1c6be55b9a89fceffe61a6666aa3'] = "admin/Holidays/addHolidays/";
$route['762a1c6be55b9a89fceffe61a6666aa3/(:any)'] = "admin/Holidays/addHolidays/$1";
$route['b045f201f68498c76b8fae94c1081e3d'] = "admin/Holidays/holidaysData";



$route['831889aa06026edc2a57fce35fad5b70'] = "admin/Manage_Matkagames/analysis";
$route['b59eaa61a2921dd0f5937fb461726530'] = "Manage_Matkaallgames/spinTheWheel";
$route['d25d221be10767a2c8c3f7fc5d738218'] = "admin/Manage_Matkagames/refreshPage";

$route['64175b4c45ba44a1ff364556867ce775123'] = "User/CrezyMatka/indexOld";
$route['64175b4c45ba44a1ff364556867ce775'] = "User/CrezyMatka/index";
$route['554fd1768805f9cac20e0d3d5ad5a6ed'] = "User/CrezyMatka/requestForSpeen";
$route['a9e9bf0bfad0b71d2f1dd126691e577f'] = "User/CrezyMatka/placeBets";

$route['2f5490d60afc6f97c69a60dfc2867249'] = "User/CrezyMatka/crezyWin";
$route['26d993243f595394c082a72ba0087efe'] = "User/CrezyMatka/flipCoin";
$route['618624235d1045c8366a1f6a69aa8c55'] = "User/CrezyMatka/requestToGetBet";
$route['46f866085c79443c31667d1ad3b700e5'] = "User/CrezyMatka/setRound";
$route['9088e680294bca441a24fc48eeb1aafa'] = "User/CrezyMatka/requestToGetBetEndLess";
$route['c6831bc694c7302fbf3bec7f9abe8ea1'] = "User/CrezyMatka/checkLoop";
$route['70a58ef8c3499e1ee8e95109558d865c'] = "User/CrezyMatka/breakLoop";
$route['6cb5951335c1417917b7955a522c36e3'] = "User/CrezyMatka/settlePendingBets";


$route['6cb5951335c1417917b7955a522c36e3asdfghjklkjhbgv'] = "User/CrezyMatka/updateWalletCrezyMatkaTest";

$route['46f866085c79443c31667d1ad3b700e5/(:any)'] = "admin/Manage_S3bucket/addVideos/$1";
$route['0571b3cbce86ae08dc5ba2b744302e53'] = "admin/Manage_S3bucket/videoList";
$route['dde26be899f802be450a5333939d150b'] = "admin/Manage_S3bucket/changeStatus";
$route['d4d107db39c79a35092a88ac6a4c47f2'] = "admin/Manage_S3bucket/deleteVideo";
$route['da9d768ee089c16eca79826dcf8a40e1'] = "admin/Manage_Matkagames/addBufferVideo";


$route['54b22f50f2014719083912d00c950505'] = "admin/Manage_CrezyMatka/crezyMarkaRateList";
$route['65d1bb984c381c800f07280f66bd67dc'] = "admin/Manage_CrezyMatka/crezyMarkaResultList";
$route['47c153ee854c6720c1b154ef62c3f6e7'] = "admin/Manage_CrezyMatka/crezyMarkaGameList";
$route['1c369001064e722d238305c1db028531'] = 'Manage_Matkaallgames/getDashboardData';
$route['4cc076a6c888b77de68c248073c96fbd'] = "admin/Manage_CrezyMatka/backBusinessCrazyWheel";


$route['bff07cc69563fe06d2260c6766e80a59'] = "admin/Manage_WorliBazar/getCustomersGgr";
$route['173e9596a0164a1b1793e8bf7322ba31'] = "admin/Manage_WorliBazar/getCustomersGgrDetail";


$route['2a1b7f9c8a7c4da319680c93d66d7c2c'] = 'User/RegularMarket/getClientDataOnRequest';
$route['55cc1a673ea36225432d47e1ae4aafcf'] = 'User/RegularMarket/getClientDataOnRequestForLaxmi';

$route['69c72c3ac16e118dcdfe98e22da00559/(:any)/(:any)'] = 'User/RegularMarket/enc/$1/$2';

// For testing
$route['75a5969f40afd25846f2be7dbe5e30f7/(:any)/(:any)/(:any)'] = "User/StarlineMarket/StarlineGameTypeListTest/$1/$2/$3";
$route['spinTheWheelTest'] = "Manage_Matkaallgames/spinTheWheelTest";
$route['3ee183ab26a84c3e03a453de4083fdff'] = "User/InstantWorli/testSocket";
$route['0853d746e5ae0314d47b3bb6e4a62218'] = "User/RedTable/requestToGetBetEndLess";


// $route['951b665a663ac8a34638ace79a17863c'] = "User/CrezyMatka/voiceToText";
$route['951b665a663ac8a34638ace79a17863c'] = "admin/Manage_CrezyMatka/checkProbability";

$route['addData'] = "admin/Manage_Matkaallgames/addData";
$route['f80ba237f7b8d2cf2fe353cbcc172f1a'] = "admin/RegularMarket/setGameRate";

$route['helper'] = "admin/dashboard/test";

$route['8ce1306112615b24b7750104891759b7/(:any)/(:any)'] = "User/GoldenTable/getResultByPercentage/$1/$2";

$route['d52fd43f65ca5d07612f11904e8919cf/(:any)/(:any)'] = "User/GoldenTable/sendMarketData/$1/$2";
$route['d16bfd08904d758109198f765ea2c4fe'] = "admin/Manage_Matkagames/selectCuttingMarketData"; 


$route['fd9f61059e32e83df6ea301ff92ecf6b/(:any)/(:any)'] = "User/GoldenTable/getResultByPercentageForTest/$1/$2";

$route['627c9e487ce67279be0ba390dbbf2735new123'] = "admin/dashboard/dashboardTest/$1/$2/$3";
$route['testCrazyWheelProfitable'] = "admin/Manage_CrezyMatka/checkProbability";

$route['446d95125df6fd42680ffa23d0cde680'] = "User/GoldenTable/analizeRiskPlayer";
$route['e461f07f96d197a108c4247c9ffc0c0d/(:any)/(:any)'] = "User/GoldenTable/riskPlayer/$1/$2";
$route['aebc7e6f6bc19ba1126688e5465e5ac2'] = "User/GoldenTable/setCustomersGGR";
$route['0bae7c7ebc089564f5ae0802fda8192d'] = "User/GoldenTable/updateCustomerDetail";
$route['871bf3f69179e79ac3f5d03a02f9eb13'] = "User/GoldenTable/checkRiskPlayers";




$route['87bf6fb0167a770ade4b74d0c275f681123'] = 'User/InstantWorli/worliSetalmentCrownJobTest';