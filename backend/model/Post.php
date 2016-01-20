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
class Post extends Db {

    function getDetailPost($post_id) {
        $arrReturn = array();
        $str_image = "";
        $sql = "SELECT * FROM post WHERE post_id = $post_id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn['data']= $row;

        $sql = "SELECT * FROM images WHERE object_id = $post_id AND object_type = 1";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['images'][] = $row;
            $str_image.= $row['url'].";";
        }

        $sql = "SELECT * FROM post_addon WHERE post_id = $post_id";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['addon'][] = $row['addon_id'];
        }

        $arrReturn['str_image'] = $str_image;
        return $arrReturn;
    }
    function getDetailProject($project_id) {
        $arrReturn = array();
        $str_image = "";
        $sql = "SELECT * FROM project WHERE project_id = $project_id";
        $rs = mysql_query($sql) or die(mysql_error());
        $row =mysql_fetch_assoc($rs);
        $arrReturn['data']= $row;

        $sql = "SELECT * FROM images WHERE object_id = $project_id AND object_type = 3";
        $rs = mysql_query($sql);
        while($row = mysql_fetch_assoc($rs)){
            $arrReturn['images'][] = $row;
            $str_image.= $row['url'].";";
        }

        $arrReturn['str_image'] = $str_image;
        return $arrReturn;
    }

    function insertPost($post_title,$post_alias,$image_url,$content,$address,$price,$cal_type,$total_area,$contact,$phone,$type_id,$estate_type_id,$city_id,$district_id,$project_type_id,$direction_id,$area_id,$legal_id,$price_id,$horizontal,$lengths,$road,$floors,$bedroom,$video_url,$longt,$latt,$str_image,$arrAddon) {
        try{
            $arrTmp = array();
            if($str_image){
                $arrTmp = explode(';', $str_image);
            }
            $user_id = $_SESSION['user_id'];
            $time = time();
            $sql = "INSERT INTO post VALUES
                            (NULL,'$post_title','$post_alias','$image_url','$content','$address','$price',
                                $cal_type,'$total_area','$contact','$phone',$type_id,$estate_type_id,$city_id,
                                $district_id,$project_type_id,$direction_id,$area_id,$legal_id,$price_id,'$horizontal',
                                '$lengths','$road','$floors','$bedroom',$time,$time,1,$user_id,'$post_title','$post_title','$post_title',0,'$video_url','$longt','$latt')";
            $rs = mysql_query($sql) or $this->throw_ex(mysql_error());
            $post_id = mysql_insert_id();
            if(!empty($arrTmp)){
                foreach ($arrTmp as $url) {
                    if($url){
                        $url_1  =  str_replace('.', '_690x460.', $url);
                        $url_2  =  str_replace('.', '_2.', $url);
                        $url_3  =  str_replace('.', '_4.', $url);
                        mysql_query("INSERT INTO images VALUES(null,'$url','$url_1','$url_2','$url_3',$post_id,1,1)") or die(mysql_error());
                    }
                }
            }
            if(!empty($arrAddon)){
                foreach($arrAddon as $addon_id){
                    mysql_query("INSERT INTO post_addon VALUES($post_id,$addon_id)");
                }
            }
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'insertPost' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getDetailUsersPost($user_id){
        $row = array();
        $sql = "SELECT * FROM users WHERE user_id = $user_id";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row;
    }
    function updatePost($post_id,$post_title,$post_alias,$image_url,$content,$address,$price,$cal_type,$total_area,$contact,$phone,$type_id,$estate_type_id,$city_id,$district_id,$project_type_id,$direction_id,$area_id,$legal_id,$price_id,$horizontal,$lengths,$road,$floors,$bedroom,$video_url,$longt,$latt,$str_image,$arrAddon,$status) {
        try{
            $arrTmp = array();
            if($str_image){
                $arrTmp = explode(';', $str_image);
            }
            $time = time();
            $sql1 = "SELECT user_id FROM post WHERE post_id = $post_id";
            $rs1 = mysql_query($sql1);
            $row1 = mysql_fetch_assoc($rs1);
            $user_id_post = $row1['user_id'];


            $sql = "UPDATE post
                    SET post_title = '$post_title',post_alias='$post_alias',image_url = '$image_url',
                        address = '$address',content = '$content',price ='$price',
                        cal_type = $cal_type,total_area = '$total_area',contact='$contact',
                        phone = '$phone',type_id = $type_id,estate_type_id = $estate_type_id,
                        city_id = $city_id,district_id = $district_id,area_id = $area_id,
                        project_type_id = $project_type_id,direction_id = $direction_id,
                        legal_id = $legal_id,price_id = $price_id,horizontal = '$horizontal',
                        lengths = '$lengths',road = '$road', floors = '$floors', bedroom = '$bedroom',
                        update_time = $time, title = '$post_title',video_url='$video_url',longt = '$longt',latt = '$latt',
                        meta_k = '$post_title',meta_d = '$post_title' ";
                        if($status!=null) $sql.=" ,status = $status";
                        $sql.=" WHERE post_id = $post_id";
            mysql_query($sql);
            if(!empty($arrTmp)){
                foreach ($arrTmp as $url) {
                    if($url){
                        $url_1  =  str_replace('.', '_690x460.', $url);
                        $url_2  =  str_replace('.', '_2.', $url);
                        $url_3  =  str_replace('.', '_4.', $url);
                        mysql_query("INSERT INTO images VALUES(null,'$url','$url_1','$url_2','$url_3',$post_id,1,1)") or die(mysql_error());
                    }
                }
            }
            if(!empty($arrAddon)){
                mysql_query("DELETE FROM post_addon WHERE post_id = $post_id");
                foreach($arrAddon as $addon_id){
                    mysql_query("INSERT INTO post_addon VALUES($post_id,$addon_id)");
                }
            }else{
                mysql_query("DELETE FROM post_addon WHERE post_id = $post_id");
            }
            if($status==1 && $user_id_post > 1){
                mysql_query("UPDATE users SET status = 1 WHERE user_id = $user_id_post");
            }
        }catch(Exception $ex){
            $arrLog = array('time'=>date('d-m-Y H:i:s'),'model'=> 'Post','function' => 'updatePost' , 'error'=>$ex->getMessage(),'sql'=>$sql);
            $this->logError($arrLog);
        }
    }
    function getEmailByUserID($user_id){
        $sql = "SELECT email FROM users WHERE user_id = $user_id";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        return $row['email'];
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