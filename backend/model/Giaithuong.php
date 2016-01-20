<?php

require_once "Db.php";

class Giaithuong extends Db {

    function getDetailGiaithuong($giaithuong_id) {
        $sql = "SELECT * FROM giaithuong WHERE giaithuong_id = $giaithuong_id";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }
    function getListGiaithuong($offset = -1, $limit = -1) {
        $sql = "SELECT * FROM giaithuong WHERE status = 1 ";
        if ($limit > 0 && $offset >= 0)
            $sql .= " LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }    
    function insertGiaithuong() {        

        $giaithuong_vi = $this->processData($_POST['giaithuong_vi']);
        $giaithuong_en = $this->processData($_POST['giaithuong_en']);

        $status = 1;    

        $url_images = $this->processData($_POST['url_image']);
        $description_vi = $this->processData($_POST['description_vi']);
        $description_en = $this->processData($_POST['description_en']);
		$content_vi = $_POST['content_vi'];
        $content_en = $_POST['content_en'];


        $seo_title = $seo_description = $seo_keyword = $giaithuong_vi;
        $giaithuong_alias = $this->changeTitle($giaithuong_vi);

        $sql = "INSERT INTO giaithuong VALUES(NULL,'$giaithuong_vi','$giaithuong_en','$giaithuong_alias',
                                    '$description_vi','$description_en','$content_vi','$content_en',
                                    '$url_images',1,'$seo_title','$seo_description','$seo_keyword')";
        mysql_query($sql) or die(mysql_error() . $sql);
    }
    function updateGiaithuong($giaithuong_id) {       

       $giaithuong_vi = $this->processData($_POST['giaithuong_vi']);
        $giaithuong_en = $this->processData($_POST['giaithuong_en']);

        $status = 1;    

        $url_images = $this->processData($_POST['url_image']);
        $description_vi = $this->processData($_POST['description_vi']);
        $description_en = $this->processData($_POST['description_en']);

        $seo_title = $seo_description = $seo_keyword = $giaithuong_vi;
        $giaithuong_alias = $this->changeTitle($giaithuong_vi);
		
		$content_vi = $_POST['content_vi'];
        $content_en = $_POST['content_en'];
		
        $sql = "UPDATE giaithuong
					SET giaithuong_vi = '$giaithuong_vi',giaithuong_en = '$giaithuong_en',giaithuong_alias = '$giaithuong_alias',
                    description_vi = '$description_vi',description_en = '$description_en',url_image = '$url_images',				
					title = '$seo_title',meta_d = '$seo_description',meta_k = '$seo_keyword',content_vi = '$content_vi' , content_en = '$content_en'					
					WHERE giaithuong_id = $giaithuong_id ";
        mysql_query($sql) or die(mysql_error() . $sql);
    }
    

}

?>