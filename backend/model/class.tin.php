<?php

require_once "class.db.php";

class tin extends db {
    /* SAN PHAM */

    function Tin_Them(&$loi) {

        $thanhcong = true;

        $idLT = $_POST[idLT];
        settype($idLT, "int");

        $TieuDe = $this->processData($_POST[TieuDe]);
        $TieuDe_KD = $this->processData($_POST[TieuDe_KD]);

        $AnHien = $_POST[AnHien];
        settype($AnHien, "int");
        $NoiBat = $_POST[NoiBat];
        settype($NoiBat, "int");

        $UrlHinh = $this->processData($_POST[UrlHinh]);
        $TomTat = $this->processData($_POST[TomTat]);

        $NoiDung = $_POST[NoiDung];

        $Title = $this->processData($_POST[Title]);
        $MetaD = $this->processData($_POST[MetaD]);
        $MetaK = $this->processData($_POST[MetaK]);
        $Ngay = strtotime('now');
        if ($Title == "")
            $Title = $TieuDe;
        if ($MetaD == "")
            $MetaD = $TieuDe;
        if ($MetaK == "")
            $MetaK = $TieuDe;
        if ($TieuDe_KD == "")
            $TieuDe_KD = $this->changeTitle($TieuDe);

        if ($thanhcong == false) {
            return $thanhcong;
        } else {
            $sql = "INSERT INTO tin
					VALUES(NULL,'$TieuDe','$TieuDe_KD','$UrlHinh','$TomTat','$NoiDung','$Title','$MetaK','$MetaD',
					$idLT,$AnHien,$NoiBat,$Ngay)";
            mysql_query($sql) or die(mysql_error() . $sql);
        }
        return $thanhcong;
    }

    function TinMoi_Them($idTinMoi, &$loi) {

        $thanhcong = true;
        $idTinMoi = (int) $idTinMoi;

        $idTL = $_POST[idTL];
        settype($idTL, "int");
        $idLT = $_POST[idLT];
        settype($idLT, "int");

        $TieuDe = $this->processData($_POST[TieuDe]);
        $TieuDe_KD = $this->processData($_POST[TieuDe_KD]);

        $AnHien = $_POST[AnHien];
        settype($AnHien, "int");
        $NoiBat = $_POST[NoiBat];
        settype($NoiBat, "int");

        $tags = rtrim(trim($_POST[tags]), ";");
        $arrTag = explode("; ", $tags);

        $UrlHinh = $this->processData($_POST[UrlHinh]);
        $TomTat = $this->processData($_POST[TomTat]);

        $NoiDung = $_POST[NoiDung];

        $Title = $this->processData($_POST[Title]);
        $MetaD = $this->processData($_POST[MetaD]);
        $MetaK = str_replace(";", ",", $this->processData($_POST[tags]));
        $Ngay = strtotime('now');
        if ($Title == "")
            $Title = $TieuDe;
        if ($MetaD == "")
            $MetaD = $TieuDe;
        if ($MetaK == "")
            $MetaK = $TieuDe;
        if ($TieuDe_KD == "")
            $TieuDe_KD = $this->changeTitle($TieuDe);

        if ($thanhcong == false) {
            return $thanhcong;
        } else {
            echo $sql = "INSERT INTO tin
					VALUES(NULL,'$TieuDe','$TieuDe_KD','$UrlHinh','$TomTat','$NoiDung','$Title','$MetaK','$MetaD',
					$idLT,$AnHien,$NoiBat,$Ngay)";
            mysql_query($sql) or die(mysql_error() . $sql);
            $sp_id = mysql_insert_id();
            if ($sp_id) {
                mysql_query("UPDATE tinmoi SET DaDuyet = 1 WHERE idTin = $idTinMoi");
            }
            if (!empty($arrTag)) {
                foreach ($arrTag as $tag) {
                    $tag_id = $this->checkTagTonTai($tag);
                    $this->addTagToArticle($sp_id, $tag_id);
                }
            }
        }
        return $thanhcong;
    }

    function Tin_Sua($idTin, &$loi) {
        settype($idTin, "int");
        $thanhcong = true;

        $idLT = $_POST[idLT];
        settype($idLT, "int");

        $TieuDe = $this->processData($_POST[TieuDe]);
        $TieuDe_KD = $this->processData($_POST[TieuDe_KD]);

        $AnHien = $_POST[AnHien];
        settype($AnHien, "int");
        $NoiBat = $_POST[NoiBat];
        settype($NoiBat, "int");



        $UrlHinh = $this->processData($_POST[UrlHinh]);
        $TomTat = $this->processData($_POST[TomTat]);
        $NoiDung = $_POST[NoiDung];

        $Title = $this->processData($_POST[Title]);
        $MetaD = $this->processData($_POST[MetaD]);
        $MetaK = $this->processData($_POST[MetaK]);

        if ($Title == "")
            $Title = $TieuDe;
        if ($MetaD == "")
            $MetaD = $TieuDe;
        if ($MetaK == "")
            $MetaK = $TieuDe;
        if ($TieuDe_KD == "")
            $TieuDe_KD = $this->changeTitle($TieuDe);

        if ($thanhcong == false) {
            return $thanhcong;
        } else {
            $sql = "UPDATE tin
					SET TieuDe = '$TieuDe',TieuDe_KD = '$TieuDe_KD',
					AnHien = $AnHien,NoiBat = '$NoiBat',
                    UrlHinh = '$UrlHinh',TomTat = '$TomTat',
					NoiDung = '$NoiDung',
					idLT = $idLT,
					Title = '$Title',MetaD = '$MetaD',MetaK = '$MetaK'					
					WHERE idTin = $idTin ";
            mysql_query($sql) or die(mysql_error() . $sql);
        }
        return $thanhcong;
    }

    function SanPham_ChiTiet($idTin) {
        $sql = "SELECT * 
				FROM tin
				WHERE idTin = $idTin";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }

    function Tin_List($idLT, $tukhoa = '', $limit = -1, $offset = -1) {
        $sql = "SELECT idTin,TieuDe,UrlHinh FROM tin 
					WHERE (tin.idLT = $idLT OR $idLT = -1) ";
        if ($tukhoa != "")
            $sql.=" AND TieuDe LIKE '%$tukhoa%' ";
        $sql.="	ORDER BY idTin DESC ";
        if ($limit > 0 && $offset >= 0)
            $sql.= " LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }

    function Duyet_List($limit = -1, $offset = -1) {
        $sql = "SELECT * FROM tinmoi 
					WHERE DaDuyet =  0
					ORDER BY idTin DESC ";
        if ($limit > 0 && $offset >= 0)
            $sql.= " LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }

    function ListTinTheoTheLoai($idTL, $offset = -1, $limit = -1) {
        $sql = "SELECT * FROM tin WHERE idTL = $idTL ORDER BY idTin DESC ";
        if ($limit > 0 && $offset >= 0)
            $sql.= " LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }

    function ListTinTheoLoaiTin($idLT, $offset = -1, $limit = -1) {
        $sql = "SELECT * FROM tin WHERE idLT = $idLT ORDER BY idTin DESC ";
        if ($limit > 0 && $offset >= 0)
            $sql.= " LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }

    function ListTinKhac($idLT, $idTin) {
        $sql = "SELECT * FROM tin WHERE idLT = $idLT AND idTin <> $idTin ORDER BY idTin DESC LIMIT 0,10 ";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }

    function Tin_ChiTiet($idTin) {
        $sql = "SELECT * FROM tin WHERE idTin = $idTin";
        $rs = mysql_query($sql);
        return $rs;
    }

    function TinMoiNhat($offset, $limit) {
        $sql = "SELECT * FROM tin WHERE AnHien = 1 ORDER BY idTin DESC  LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }

    function TinNoiBat($offset, $limit) {
        $sql = "SELECT * FROM tin WHERE AnHien = 1 AND NoiBat = 1 ORDER BY idTin DESC  LIMIT $offset,$limit";
        $rs = mysql_query($sql) or die(mysql_error());
        return $rs;
    }

    function getTagsByProductId($sp_id) {
        $sql = "SELECT tag_id FROM sp_tag WHERE sp_id = $sp_id";
        $rs = mysql_query($sql);
        return $rs;
    }

    function getTagsOfProductId($sp_id) {
        $arr = array();
        $sql = "SELECT tag_id FROM sp_tag WHERE sp_id = $sp_id";
        $rs = mysql_query($sql);
        if (!empty($rs)) {
            while ($row = mysql_fetch_assoc($rs)) {
                $arr[] = $row['tag_id'];
            }
        }
        return $arr;
    }

    function getDetailTag($tag_id) {
        $sql = "SELECT * FROM tag WHERE tag_id = $tag_id";
        $rs = mysql_query($sql);
        return $rs;
    }

    function getDetailTagByTag_KD($tag_kd) {
        $sql = "SELECT * FROM tag WHERE tag_name_kd = '$tag_kd'";
        $rs = mysql_query($sql);
        return $rs;
    }

    function GetNoiDung($id) {
        $sql = "SELECT NoiDung FROM noidung WHERE idND = $id";
        $rs = mysql_query($sql);
        $row = mysql_fetch_assoc($rs);
        $noidung = $row['NoiDung'];
        return $noidung;
    }

    function NoiDung_ChiTiet($id) {
        $sql = "SELECT * FROM noidung WHERE idND = $id";
        $rs = mysql_query($sql);
        return $rs;
    }

    function NoiDung_Sua($id) {
        $noidung = $_POST['NoiDung'];
        $sql = "UPDATE noidung SET NoiDung = '$noidung' WHERE idND = $id";
        $rs = mysql_query($sql);
    }

    function Banner_Edit() {
        $trai = $_POST['UrlHinh_Trai'];
        $phai = $_POST['UrlHinh_Phai'];
        mysql_query("UPDATE noidung SET NoiDung = '$trai' WHERE idND = 3");
        mysql_query("UPDATE noidung SET NoiDung = '$phai' WHERE idND = 4");
    }
    
    function TinMoi(){
        $rs = mysql_query("SELECT * FROM tin ORDER BY idTin DESC LIMIT 0,6") or die(mysql_error());
        return $rs;
    }
    function TinXemNhieu(){
        $rs = mysql_query("SELECT * FROM tin ORDER BY rand() LIMIT 0,5") or die(mysql_error());
        return $rs;
    }
    
}

?>