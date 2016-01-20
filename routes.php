<?php
if(!isset($_SESSION)){
    session_start();
}
require_once 'backend/model/Frontend.php';
$model = new Frontend;
$mod = isset($_GET['mod']) ? $_GET['mod'] : "";
$arrText = $model->getListText();
function checkCat($uri) {

    require_once 'backend/model/Frontend.php';    
    $model = new Frontend;

    $uri = str_replace("+", "", $uri);

    $p_detail = '#chi-tiet/[a-z0-9\-\+]+\-\d+.html#';
    $p_detail_news = '#tin-tuc/[a-z0-9\-\+]+\-\d+.html#';
     $p_cate_page = '#/[a-z0-9\-\+]+.html#';
     $p_product_detail = '#[a-z0-9\-\+]/[a-z0-9\-\+]/[a-z0-9\-\+]+.html#';
    $p_cate_news = '#danh-muc/[a-z0-9\-\+]+\-\d+.html#';
    $p_detail_event = '#su-kien/[a-z0-9\-\+]+\-\d+.html#';
    $p_tag = '#/tag/[a-z\-]+.html#';
	$p_contact = '#/lien-he+.html#';
    $p_order = '#/quan-ly-don-hang+.html#';
    $p_orderdetail = '#/chi-tiet-don-hang+.html#';
    $p_info = '#/cap-nhat-thong-tin+.html#';
    $p_changepass = '#/doi-mat-khau+.html#';
    $p_logout = '#/thoat+.html#';
	$p_hot = '#/[a-z0-9\-]+\-+c+\d+h+\d+.html#';
	$p_sale = '#/[a-z0-9\-]+\-+c+\d+s+\d+.html#';
   

    $p_cart = '#/gio-hang+.html#';
    $p_register = '#/dang-ky+.html#';
    $p_about = '#/gioi-thieu+.html#';
    $p_thanhtoan = '#/thanh-toan+.html#';
	$p_tintuc = '#/tin-tuc+.html#';
    $p_cate =  '#/[a-z0-9\-]+\-+p+\d+.html#';    
    $p_content =  '#/[a-z0-9\-]+\-+c+\d+.html#';
    $p_search = '#/tim-kiem+.html#';
    
    $mod = $seo = "";
    $uri = str_replace(".html", '', $uri);
    $object_id = 0;
    $city_id = $district_id = $type_id = $price_id = "";
    $arrTmp = explode('/',$uri);    
    unset($arrTmp[0]);
    if(strpos($uri, 'trang/')){
        $mod = "page";        
    }elseif(strpos($uri, 'chi-tiet/')){
        $mod = "detail";        
    }elseif(strpos($uri, 'tin-tuc')){
        $mod = "news";        
    }elseif(strpos($uri, 'chi-tiet-tin')){
        $mod = "news-detail";
    }else{
        
        if(isset($arrTmp[1]) && $arrTmp[1] != ''){        
            $alias = $model->processData($arrTmp[1]);
            $detail = $model->getDetailByAlias('type_bds', $alias);        
            $type_id = $detail['id'];
            $mod = "list";
            $type = $detail['type'];
        }else{
            $type_id = 1;
            $mod = "home";
        }
        if(isset($arrTmp[2])){        
            $alias = $model->processData($arrTmp[2]);
            $detail = $model->getDetailByAlias('city', $alias);        
            $city_id = $detail['id'];
        }else{
            $city_id = 1;
        }

        if(isset($arrTmp[3])){
            $alias = $model->processData($arrTmp[3]);
            
            $detail = $model->getDetailByAlias('district', $alias);
            if($detail){
                $district_id = $detail['id'];
            }else{
                $district_id = 0;                
                $detail = $model->getDetailByAlias('price', $alias);        
                if($detail){
                    $price_id = $detail['id'];
                }
            }                        
        }else{
            $district_id = 0;
        }
        if($price_id == ""){
            if(isset($arrTmp[4])){
                $alias = $model->processData($arrTmp[4]);
                $detail = $model->getDetailByAlias('price', $alias);        
                $price_id = $detail['id'];
            }else{
                $price_id = -1;
            }
        }
    }
    /*
    var_dump($city_id);die;
    if(count($arrTmp) == 4){
        $mod = "detail";        
    }elseif(strpos($uri, 'tin-tuc/')){

        $mod = "detail-news";
        
    }elseif(strpos($uri, 'tim-kiem.')){

        $mod = "search";
        
    }elseif(strpos($uri, 'dat-hang-thanh-cong.')){

        $mod = "thanks";
        
    }elseif(strpos($uri, 'danh-muc/')){

        $mod = "cate-news";
        
    }elseif(strpos($uri, 'dang-ky')){

        $mod = "register";
        if(!empty($_SESSION['user'])){  
            $rel = isset($_GET['rel']) ? $_GET['rel'] : 'gio-hang';    
            header('location:'.$rel.'.html');
        }
        
    }elseif(strpos($uri, 'cap-nhat-thong-tin')){

        $mod = "info";        
        if(empty($_SESSION['user'])){         
            header('location:dang-ky.html');
        }
       
        
    }elseif(strpos($uri, 'quan-ly-don-hang')){
       
        $mod = "order";               
        if(empty($_SESSION['user'])){         
            header('location:dang-ky.html');
        }
        
    }elseif(strpos($uri, 'chi-tiet-don-hang')){
       
        $mod = "orderdetail";               
        if(empty($_SESSION['user'])){         
            header('location:dang-ky.html');
        }
        
    }elseif(strpos($uri, 'doi-mat-khau')){
        $mod = "changepass";
        $seo = $model->getDetailSeo(9);
        if(empty($_SESSION['user'])){         
            header('location:dang-ky.html');
        }
    }else{
    	if (preg_match($p_product_detail, $uri)) {
            $mod = "product_detail";        
        }
        if (preg_match($p_cart, $uri)) {
            $mod = "cart";        
            if(empty($_SESSION['user'])){         
            //    header('location:dang-ky.html');
            }
        }
        if (preg_match($p_search, $uri)) {
            $mod = "search";        
        }	
        if (preg_match($p_cate_page, $uri)) {           
            
            $uri =  substr($uri, 1);     
            $tmp = explode(".", $uri);
            
            if($tmp[0] == "lien-he"){
                $mod = "contact";
            }elseif($tmp[0] == "thanh-toan"){
                $mod = "thanhtoan";
            }elseif($tmp[0] =="tin-tuc"){
                $mod = "news";
                $seo = $model->getDetailSeo(4);
            }else{                
                $row = $model->getDetailAlias($tmp[0]);
                $mod = $row['type'] == 1 ? "cate" : "content";
                $object_id = $row['object_id'];
            }
        }   
       
        if (preg_match($p_about, $uri)) {
            $mod = "about";
            $seo = $model->getDetailSeo(2);
        }
    	
        if (preg_match($p_thanhtoan, $uri)) {
            $mod = "thanhtoan";       
            if(empty($_SESSION['user'])){         
            //    header('location:dang-ky.html');
            }
        }        
        if (preg_match($p_detail_news, $uri)) {
            $mod = "detail-news";
        }
        if (preg_match($p_detail_event, $uri)) {
            $mod = "detail-event";
        }
    	if (preg_match($p_tintuc, $uri)) {
            $mod = "news";
            $seo = $model->getDetailSeo(4);
        }
        if (preg_match($p_cate_news, $uri)) {
            $mod = "cate-news";
        }
        
        if (preg_match($p_cate, $uri)) {
            $mod = "cate";
        }
        if (preg_match($p_content, $uri)) {
            $mod = "content";
        }
    	if (preg_match($p_hot, $uri) || preg_match($p_sale, $uri)) {
            $mod = "catetype";
        }
    	
        if (preg_match($p_contact, $uri)) {
            $mod = "contact";        
        }
        
        if (preg_match($p_logout, $uri)) {        
            session_destroy();
            $mod = "";
            $seo = $model->getDetailSeo(1);
        }
        */
    
    return array("seo"=>$seo, "mod" =>$mod,'object_id' => $object_id, 'city_id' => $city_id, 'district_id' => $district_id,
        'price_id' => $price_id, 'type_id' => $type_id);
}

$uri = $_SERVER['REQUEST_URI'];

$arrRS = checkCat($uri);

$mod = $arrRS['mod'];
$type_id = $arrRS['type_id']; 
$city_id = $arrRS['city_id']; 
$district_id = $arrRS['district_id']; 
$price_id = $arrRS['price_id']; 

$uri = str_replace(".html", "", $uri);
$tmp_uri = explode("/", $uri);
if($mod==''){
	if(isset($_GET["payment"]) && $_GET['payment']=="success"){
		unset($_SESSION["cart"]);
	}
}
switch ($mod) {
    case "news":
		/*$tieude_id = $tmp_uri[1];
        $arr = explode("-", $tieude_id);
		$page = (int) end($arr);
		$page = ($page==0) ? 1 : $page;
        */
        $seo = $model->getDetailSeo(4);        
        
        break;    
    case "contact": 
        $seo = $model->getDetailSeo(3);              
        break;
    case "info" : 
        $seo = $model->getDetailSeo(8);
        break;
    case "detail":            
        $detail  = $imageHouseArr = array();
        $product_alias = $tmp_uri[2];        
        $tmp = explode("-", $product_alias);        
	    $id = (int) end($tmp);
        
        $seo = $detail = $model->getDetail("objects", $id);
        $object_type = $detail['object_type'];
        $type_id = $detail['type_id'];  
        $detailType = $model->getDetail('type_bds', $type_id);
        if($object_type == 1){
            $convenientArr = $model->getList('convenient', -1, -1);
            $arrAddonSelected = $model->getListRoomInfo($id, 1);
            $arrConvenientSelected = $model->getListRoomInfo($id, 2);
            $imageArr = $model->getChild("images", "object_id", $id, 2);    
            $houseDetail = $model->getDetail("house", $detail['house_id']);
            $imageHouseArr = $model->getChild("images", "object_id", $detail['house_id'], 1);
            $detailMod = $model->getDetail('users', $houseDetail['user_id']);
            $houseServiceArr = $model->getHouseServices($detail['house_id']);
        }else{    
            $type_images =  ($object_type==3) ? 4 : 1;
            $imageHouseArr = $model->getChild("images", "object_id", $id, $type_images);

            $detailMod = $model->getDetail('users', $detail['user_id']); 
            $houseServiceArr = $model->getHouseServices($detail['id']);
        }
        /*
        $data = $seo = $arrDetailProduct['data'];
        $parent_id = $data['parent_cate'];
        $cate_type_id = $data['cate_type_id'];
        $_SESSION['view'][$product_id] = $data;        
        $arrRelated = $model->getProductRelated($parent_id,$product_id);         
        $arrDetailCate =$model->getDetailCate($parent_id); 
        $arrDetailCateType =$model->getDetailCateType($cate_type_id); 
        */
        break;
    case "news-detail":        
        $article_alias = $tmp_uri[2];        
        $tmp = explode("-", $article_alias);        
        $id = (int) end($tmp);
        $detail = $model->getDetail('articles', $id);
        $seo = $detail;
	    break; 
    case "content":        
        $page_id = $object_id; 
        $data = $seo = $model->getDetailPage($page_id);
        break;
    case "page":
        $alias = $tmp_uri[2];
        $detailArr = $seo = $model->getDetailPageByAlias($alias);
        //$rs_article = $model->getDetail('pages', $page_id);
        //$arrDetailPage = mysql_fetch_assoc($rs_article);
        break;
    default :    
        $seo = $model->getDetailSeo(1);
        break;
}
?>