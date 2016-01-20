<?php
include "model/Db.php";
try{

    include "../model/Db.php";
}catch(Exception $ex){

}
if(!isset($_SESSION)) 
{ 
    session_start(); 
}  
class Articles extends Db {

    function getDetailArticle($article_id) {
        $arrReturn = array();
        $str_image = "";
        $sql = "SELECT * FROM articles WHERE article_id = $article_id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn['data']= $row;

        $sql = "SELECT * FROM images WHERE object_id = $article_id AND object_type = 2";
        $rs = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['images'][] = $row;
            $str_image.= $row['url'].";";            
        }
        $arrReturn['str_image'] = $str_image;        
        return $arrReturn;
    }
   
    function getListArticle($keyword='', $category_id=-1,$offset = -1, $limit = -1) {
        try{
            $arrResult = array();
            $sql = "SELECT * FROM articles WHERE (category_id = $category_id OR $category_id = -1) ";
            if(trim($keyword) != ''){
                $sql.= " AND article_title LIKE '%".$keyword."%' " ;
            }    
            $sql.=" AND status = 1 ORDER BY article_id DESC ";
            if ($limit > 0 && $offset >= 0)
                $sql .= " LIMIT $offset,$limit";
            
            $rs = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_assoc($rs)){
               $arrResult['data'][] = $row; 
            }

            $arrResult['total'] = mysql_num_rows($rs);   
            return $arrResult;  
        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Articles','function' => 'getListArticle' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
   

    function insertArticles($article_title,$title_safe,$image_url,$description,$content,$category_id,$arrTag,$str_image) {
        try{
            //$user_id = $_SESSION['user_id'];
            $time = time();
            $user_id = 1;
            $sql = "INSERT INTO articles VALUES
                            (NULL,'$article_title','$title_safe','$description','$content','$image_url',
                                $category_id,1,$time,$time,'$article_title','$article_title','$article_title',$user_id)";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());
            $article_id = mysql_insert_id();
            
            if(!empty($arrTag)){
                foreach($arrTag as $tag){
                    $tag = trim($tag);
                    $tag_id = $this->checkTagTonTai($tag);
                    $this->addTagToArticle($article_id,$tag_id);
                }
            }

            $arrTmp = array();
            if($str_image){
                $arrTmp = explode(';', $str_image);
            }

            if(!empty($arrTmp)){
                foreach ($arrTmp as $url) {
                    if($url){
                        $url_1  =  str_replace('.', '_690x460.', $url);
                        $url_2  =  str_replace('.', '_2.', $url);
                        $url_3  =  str_replace('.', '_4.', $url);
                        mysql_query("INSERT INTO images VALUES(null,'$url','$url_1','$url_2','$url_3',$article_id,2,1)") or die("insert images" . mysql_error());
                    }
                }
            }


        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Articles','function' => 'insertArticle' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }

    function getTagsByProductId($article_id){
        $sql = "SELECT tag_id FROM articles_tag WHERE article_id = $article_id";
        $rs = mysql_query($sql);
        return $rs;
    }
    function getTagsOfProductId($article_id){
        $arr = array();
        $sql = "SELECT tag_id FROM articles_tag WHERE article_id = $article_id";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arr[] = $row['tag_id']; 
        }
        return $arr;
    }
    function getDetailTag($tag_id){
        $sql = "SELECT * FROM tag WHERE tag_id = $tag_id";
        $rs = mysql_query($sql);
        return $rs;
    }    

    function updateArticles($article_id,$article_title,$title_safe,$image_url,$description,$content,$category_id,$arrTag,$str_image) {
       try{
            //$user_id = $_SESSION['user_id'];
            $arrTmp = array();
            if($str_image){
                $arrTmp = explode(';', $str_image);
            }
            $time = time();
            $user_id = 1;
            $sql = "UPDATE articles
                        SET article_title = '$article_title',   article_alias = '$title_safe',
                        image_url = '$image_url',
                        description = '$description',content = '$content',                    
                        category_id = $category_id, meta_d = '$meta_d', title = '$title',meta_k = '$meta_k',                    
                        update_time = $time,
                        user_id = $user_id              
                        WHERE article_id = $article_id ";
            mysql_query($sql)  or $this->throw_ex(mysql_error());  

            if(!empty($arrTag)){                  
                mysql_query("DELETE FROM articles_tag WHERE article_id = $article_id AND object_type = 2");
                foreach($arrTag as $tag){
                    $tag_id = $this->checkTagTonTai($tag);
                    $this->addTagToArticle($article_id,$tag_id);
                }
            }else{
                mysql_query("DELETE FROM articles_tag WHERE article_id = $article_id AND object_type = 2");
            }

            if(!empty($arrTmp)){
                foreach ($arrTmp as $url) {
                    if($url){
                        $url_1  =  str_replace('.', '_690x460.', $url);
                        $url_2  =  str_replace('.', '_2.', $url);
                        $url_3  =  str_replace('.', '_4.', $url);
                        mysql_query("INSERT INTO images VALUES(null,'$url','$url_1','$url_2','$url_3',$article_id,2,1)") or die(mysql_error());
                    }
                }
            }

        }catch(Exception $ex){            
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Articles','function' => 'updateArticle' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }

    function checkTagTonTai($tag){
        $sql = "SELECT tag_id FROM tag WHERE BINARY tag_name LIKE '%$tag%'";
        $rs = mysql_query($sql);
        $row = mysql_num_rows($rs);
        if($row == 1){
            $row = mysql_fetch_assoc($rs);
            $idTag = $row['tag_id'];
        }else{
            $tag_kd = $this->changeTitle($tag);
            $idTag = $this->insertTag($tag,$tag_kd);
        }
        return $idTag;
    }
    function insertTag($tag,$tag_kd){
        $sql = "INSERT INTO tag VALUES (NULL,'$tag','$tag_kd')";
        $rs = mysql_query($sql) or die(mysql_error());
        $id= mysql_insert_id();
        return $id;         
    }
    function addTagToArticle($article_id,$tag_id){
        $sql = "INSERT INTO articles_tag VALUES ($article_id,$tag_id,2)";
        mysql_query($sql) or die(mysql_error());
    }
    

}

?>