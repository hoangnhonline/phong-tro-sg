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
class Project extends Db {    

    function insertProject($project_name,$project_alias,$project_type_id,$district_id,$address,$contact,$phone,$image_url,$video_url,$description,$content,$hot,$longt,$latt,$str_image) {
        try{
            $arrTmp = array();
            if($str_image){
                $arrTmp = explode(';', $str_image);
            }
            $user_id = 1;
            $time = time();
            $sql = "INSERT INTO project VALUES
                            (NULL,'$project_name','$project_alias',$project_type_id,$district_id,'$address','$contact',
                                '$phone','$image_url','$video_url','$description','$content',$hot,'$longt','$latt',
                                1,'$project_name','$project_name','$project_name',$time,$time)";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());
            $project_id = mysql_insert_id();
            if(!empty($arrTmp)){
                foreach ($arrTmp as $url) {
                    if($url){
                        $url_1  =  str_replace('.', '_690x460.', $url);
                        $url_2  =  str_replace('.', '_2.', $url);
                        $url_3  =  str_replace('.', '_4.', $url);
                        mysql_query("INSERT INTO images VALUES(null,'$url','$url_1','$url_2','$url_3',$project_id,3,1)") or die(mysql_error());
                    }
                }
            }            
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Project','function' => 'insertProject' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function updateProject($project_id,$project_name,$project_alias,$project_type_id,$district_id,$address,$contact,$phone,$image_url,$video_url,$description,$content,$hot,$longt,$latt,$str_image){      
        try{
            $arrTmp = array();
            if($str_image){
                $arrTmp = explode(';', $str_image);
            }
            $user_id = 1;
            $time = time();
            $sql = "UPDATE project 
                    SET project_name = '$project_name',project_alias='$project_alias',project_type_id = $project_type_id,
                        district_id = $district_id,address = '$address',contact ='$contact',
                        phone = '$phone',image_url = '$image_url',video_url='$video_url',
                        description = '$description',content = '$content',hot = $hot,                        
                        update_time = $time, title = '$project_name',longt = '$longt',latt = '$latt',
                        meta_k = '$project_name',meta_d = '$project_name' WHERE project_id = $project_id";
            mysql_query($sql);           
            if(!empty($arrTmp)){
                foreach ($arrTmp as $url) {
                    if($url){
                        $url_1  =  str_replace('.', '_690x460.', $url);
                        $url_2  =  str_replace('.', '_2.', $url);
                        $url_3  =  str_replace('.', '_4.', $url);
                        mysql_query("INSERT INTO images VALUES(null,'$url','$url_1','$url_2','$url_3',$project_id,3,1)") or die(mysql_error());
                    }
                }
            }            
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Project','function' => 'updateProject' , 'error'=>$ex->getMessage(),'sql'=>$sql);
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

    function updateArticles($article_id,$title,$title_safe,$image_url,$description,$content,$category_id,$hot,$title_en,$arrTag) {
       try{
        $user_id = $_SESSION['user_id'];
        $time = time();

        $sql = "UPDATE articles
                    SET title = '$title',title_safe = '$title_safe',
                    image_url = '$image_url',
                    description = '$description',content = '$content',
                    category_id = $category_id, hot = $hot, title_en = '$title_en',
                    update_time = $time,
                    user_id = $user_id
                    WHERE article_id = $article_id ";
        mysql_query($sql)  or $this->throw_ex(mysql_error());

        if(!empty($arrTag)){
            mysql_query("DELETE FROM articles_tag WHERE article_id = $article_id");
            foreach($arrTag as $tag){
                $tag_id = $this->checkTagTonTai($tag);
                $this->addTagToArticle($article_id,$tag_id);
            }
        }else{
            mysql_query("DELETE FROM articles_tag WHERE article_id = $article_id");
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
        $sql = "INSERT INTO articles_tag VALUES ($article_id,$tag_id)";
        mysql_query($sql) or die(mysql_error());
    }


}

?>