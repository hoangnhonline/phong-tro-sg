<?php

require_once "Db.php";

class Article extends Db {
    function __construct() {
        if($_SERVER['SERVER_NAME']=='nhadat.dev'){
            mysql_connect('localhost', 'root', '') or die("Can't connect to server");
               mysql_select_db('sth_bds') or die("Can't connect database");
        }else{
        mysql_connect('localhost', 'sth_bds', 'batdongsan@sth') or die("Can't connect to server");
            mysql_select_db('sth_bds') or die("Can't connect database"); 
        }
        mysql_query("SET NAMES 'utf8'") or die(mysql_error());
    }
    function getDetailArticle($article_id) {
        $sql = "SELECT * FROM article WHERE article_id = $article_id";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }
    function getDetailService($service_id) {
        $sql = "SELECT * FROM services WHERE service_id = $service_id";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }

    function menu_list() {
        $sql = "SELECT * FROM menu ORDER BY menu_id DESC";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }

    function getListArticleByLang($lang_id = -1, $offset = -1, $limit = -1) {
        $sql = "SELECT * FROM article WHERE (lang_id = $lang_id OR $lang_id = -1) AND status = 1 ";
        if ($limit > 0 && $offset >= 0)
            $sql .= " LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }
    function getListServiceByCategory($category_id = -1, $offset = -1, $limit = -1) {
        $sql = "SELECT * FROM services WHERE (category_id = $category_id OR $category_id = -1) AND status = 1 ";
        if ($limit > 0 && $offset >= 0)
            $sql .= " LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }
    function addArticleToMenu($menu_id, $article_id) {
        $sql = "UPDATE menu SET article_id = $article_id WHERE menu_id = $menu_id";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }

    function insertArticle() {
        $category_id = $status =  1;
        $lang_id = (int) $_POST['lang_id'];

        $article_title = $this->processData($_POST['article_title']);

        $url_images = $this->processData($_POST['url_image']);

        $description = $this->processData($_POST['description']);

        $content = $_POST['content_bv'];        

        $seo_title = $seo_description = $seo_keyword = $article_title;
        $title_alias = $this->changeTitle($article_title);

        $sql = "INSERT INTO article	VALUES(NULL,'$article_title','$title_alias','$description','$content','$url_images','$lang_id',1,1)";
        $rs = mysql_query($sql) or $this->throw_ex(mysql_error());       
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Article','function' => 'insertArticle' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function insertService() {
        $category_id = 1;

        $service_name_vi = $this->processData($_POST['service_name_vi']);
        $service_name_en = $this->processData($_POST['service_name_en']);

        $status = 1;    

        $url_images = $this->processData($_POST['url_image']);
        $description_vi = $this->processData($_POST['description_vi']);
        $description_en = $this->processData($_POST['description_en']);

        $content_vi = $_POST['content_vi'];
        $content_en = $_POST['content_en'];
        $date = time();

        $category_id = (int) $_POST['category_id'];

        $seo_title = $seo_description = $seo_keyword = $service_name_vi;
        $service_alias = $this->changeTitle($service_name_vi);

        $sql = "INSERT INTO services VALUES(NULL,'$service_name_vi','$service_name_en','$service_alias',
                                    '$description_vi','$description_en','$content_vi','$content_en',1,
                                     $category_id,'$url_images','$seo_title','$seo_description','$seo_keyword',$date)";
        mysql_query($sql) or $this->throw_ex(mysql_error());       
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Article','function' => 'insertService' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function updateService($service_id) {
        $category_id = 1;

        $service_name_vi = $this->processData($_POST['service_name_vi']);
        $service_name_en = $this->processData($_POST['service_name_en']);

        $status = 1;    

        $url_images = $this->processData($_POST['url_image']);
        $description_vi = $this->processData($_POST['description_vi']);
        $description_en = $this->processData($_POST['description_en']);

        $content_vi = $_POST['content_vi'];
        $content_en = $_POST['content_en'];

        $seo_title = $seo_description = $seo_keyword = $service_name_vi;
        $service_alias = $this->changeTitle($service_name_vi);

        $sql = "UPDATE services
					SET service_name_vi = '$service_name_vi',service_name_en = '$service_name_en',service_alias = '$service_alias',
                    description_vi = '$description_vi',description_en = '$description_en',content_vi = '$content_vi',
					content_en = '$content_en',url_image = '$url_images',				
					title = '$seo_title',meta_d = '$seo_description',meta_k = '$seo_keyword'					
					WHERE service_id = $service_id ";
        mysql_query($sql) or $this->throw_ex(mysql_error());       
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Article','function' => 'updateService' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }

    function updateArticle($article_id) {
        $category_id = $status =  1;
        $lang_id = (int) $_POST['lang_id'];

        $article_title = $this->processData($_POST['article_title']);

        $url_images = $this->processData($_POST['url_image']);

        $description = $this->processData($_POST['description']);

        $content = $_POST['content_bv'];        

        $seo_title = $seo_description = $seo_keyword = $article_title;
        $title_alias = $this->changeTitle($title);


        $sql = "UPDATE article
                    SET article_title = '$article_title',article_alias = '$title_alias',
                    content = '$content',url_image = '$url_images',description = '$description',                    
                    lang_id = '$lang_id'                  
                    WHERE article_id = $article_id ";
        mysql_query($sql)  or $this->throw_ex(mysql_error());       
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Article','function' => 'updateArticle' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }

}

?>