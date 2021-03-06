<?php

class Model_product extends Model_db{
    function listRecords() 
    {
        $sql = "SELECT * FROM book order by id";
        return $this->result1(0,$sql);
    }
   
    public function addNewProduct( 
                $name, $slug, $imgs, $type, $class, 
                $author, $year, $description, $link,$part,
                $linksachmengv,$linksachmemhs ,$linkSachGv,
                $linksachgv2,$linkudnghenoi,
                $linkdekiemtra,$linkstoryland,$linkppct,
                $linkudluyentuvung,$linkudluyennghenoi,
                $linkhoverimg,$sachmem,
                $idcate
    )
    {
        $sql = "
                INSERT INTO book(
                name, slug, img, type, class, author, 
                year, description,link,part,linksachmengv,linksachmemhs,
                linkgv,linksachgv2,linkudnghenoi,
                linkdekiemtra,linkstoryland,linkppct,linkudluyentuvung,
                linkudluyennghenoi,linkhoverimg,sachmem, idcate) VALUE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        return $this->getLastId($sql,  $name, $slug, $imgs, $type, $class, 
                $author, $year, $description, $link,$part,
                $linksachmengv,$linksachmemhs ,$linkSachGv,
                $linksachgv2,$linkudnghenoi,
                $linkdekiemtra,$linkstoryland,$linkppct,
                $linkudluyentuvung,$linkudluyennghenoi,
                $linkhoverimg,$sachmem,
                $idcate);
    }

    function deleteProduct($id)
    {   
        $sql = "DELETE FROM book WHERE id = ?";
        return $this->exec1($sql,$id);
    }
    
    function editProduct( 
                $name, $slug, $imgs, $type, $class, 
                $author, $year, $description, $link,$part,
                $linksachmengv,$linksachmemhs ,$linkSachGv,
                $linksachgv2,$linkudnghenoi,
                $linkdekiemtra,$linkstoryland,$linkppct,
                $linkudluyentuvung,$linkudluyennghenoi,
                $linkhoverimg,$sachmem,
                $idcate, $id
        ){
        if($imgs == "")
        {
        $sql = "UPDATE book SET name = ?, slug = ?,
                type = ?, class = ?, author = ?,
                year = ?, description = ?, link = ?, part=?,linksachmengv=?,
                linksachmemhs=?,linkgv=?,linksachgv2=?,
                linkudnghenoi=?,linkdekiemtra=?,linkstoryland=?,linkppct=?,
                linkudluyentuvung=?,linkudluyennghenoi	=?,linkhoverimg=?,
                sachmem=?,
                idcate = ?  WHERE id=?";
        return $this->exec1(
                $sql,  $name, $slug, $type, $class, 
                $author, $year, 
                $description,
                $link,$part,
                $linksachmengv,$linksachmemhs ,$linkSachGv,
                $linksachgv2,$linkudnghenoi,
                $linkdekiemtra,$linkstoryland,$linkppct,
                $linkudluyentuvung,$linkudluyennghenoi,
                $linkhoverimg,$sachmem,
                $idcate, $id
        );

        }else
        {
        $sql = "UPDATE book SET name = ?, slug = ?, img= ?,
                type = ?, class = ?, author = ?,
                year = ?, description = ?, link = ?, part=?,linksachmengv=?,
                linksachmemhs=?,linkgv=?,linksachgv2=?,
                linkudnghenoi=?,linkdekiemtra=?,linkstoryland=?,linkppct=?,
                linkudluyentuvung=?,linkudluyennghenoi	=?,linkhoverimg=?,
                sachmem=?,
                idcate = ?  WHERE id=?";
        return $this->exec1(
                $sql,$name, $slug, $imgs, $type, $class, 
                $author, $year, $description, $link,$part,
                $linksachmengv,$linksachmemhs ,$linkSachGv,
                $linksachgv2,$linkudnghenoi,
                $linkdekiemtra,$linkstoryland,$linkppct,
                $linkudluyentuvung,$linkudluyennghenoi,
                $linkhoverimg,$sachmem,
                $idcate, $id);
        }
    }

    function getDetailProductById($id)
    {
        $sql = "SELECT * FROM book WHERE id=?";
        return $this->result1(1,$sql,$id);
    }
    function countAllProduct()
    {
        $sql = "SELECT count(*) AS sodong FROM book";
        return $this->result1(1,$sql)['sodong'];
    }

    public function Page (int $TotalProduct, int $CurrentPage)
    {
        $LimitPage = 5; // 5 s???n ph???m 2 trang

        $PagedHTML = ''; // kh???i t???o

        $CurrentQuery = $_GET; //query hi???n t???i

        $NextQuery = $_GET; //next query
        $PrevQuery = $_GET; // query tr?????c

        $LastQuery = $_GET; // query tr?????c ????y
        $FirstQuery = $_GET; // query ?????u ti??n

        $IsLastButtonHidden = '';
        $IsNextButtonHidden = '';

        $IsFirstButtonHidden = '';
        $IsPreviousButtonHidden = '';

        $TotalPage = ceil($TotalProduct / PAGE_SIZE); // t???ng s??? page

        if($CurrentPage === 1)
        {
            $IsFirstButtonHidden = 'hidden';
            $IsPreviousButtonHidden = 'hidden';
        }
        // n???u page == 1 th?? kh??ng cho quay v??? trang tr?????c

        if ((int) $CurrentPage === (int) $TotalPage)
        {
            $IsLastButtonHidden = 'hidden';
            $IsNextButtonHidden = 'hidden';
        }
        // n???u t???ng s??? page hi???n t???i == current page th?? kh??ng c?? ti???p t???c

        $NextQuery['Page'] = $CurrentPage + 1;     //t???o ra query ti???p theo
        $LastQuery['Page'] = $TotalPage; // t???o ra query cu???i
   


        $NextButton = '<li class="'.$IsNextButtonHidden.' page-item"><a class="page-link" href="?'.http_build_query($NextQuery).'">></a></li>';
        $LastButton = '<li class="'.$IsLastButtonHidden.' page-item"><a class="page-link" href="?'.http_build_query($LastQuery).'">>|</a></li>';

        $PrevQuery['Page'] = $CurrentPage - 1; //tr??? v??? trang tr?????c
        $FirstQuery['Page'] = 1; // tr??? v??? trang 1

        $PreviousButton = '<li class="'.$IsFirstButtonHidden.' page-item"><a class="page-link" href="?'.http_build_query($PrevQuery).'"><</a></li>';
        $FirstButton = '<li class="'.$IsPreviousButtonHidden.' page-item"><a class="page-link" href="?'.http_build_query($FirstQuery).'">|<</a></li>';
        // tr??? v??? trang tr?????c
        // tr??? v??? trang ????u
        $PagedHTML .= $FirstButton.$PreviousButton;
        //t???o html
        if ($CurrentPage <= $TotalPage && $TotalPage >= 1) // n???u page hi???n t???i nh??? h??n ho???c b???ng t???ng s??? page v?? v?? t???ng s??? page >=1
        {
            $PageBreak = 1; // break page

            if ($CurrentPage > ($LimitPage / 2)) // n???u page hi???n t???i l???n hon 5/2 
            {
                $CurrentQuery['Page'] = 1; // page hi???n t???i b???ng 1 

                $PagedHTML .= '<li class="page-item"><a class="page-link" href="?'.http_build_query($CurrentQuery).'">1</a></li>'; // trang ?????u
                $PagedHTML .= '<li class="page-item"><a class="page-link">...</a></li>'; // ?????n ....
            }

            $Loop = $CurrentPage; // l???p = page hi???n t???i
           
            while ($Loop <= $TotalPage) // curren page => t???ng s??? page
            {
                if ($PageBreak < $LimitPage) // n???u pagebreak ++ n???u pagebreak < 5 (limit page)
                {
                    $CurrentQuery['Page'] = $Loop; // g??n l???i cho current query

                    if ($CurrentPage === $Loop) // n???u currentpage == loop
                    {
                        $PagedHTML .= '<li class="active page-item"><a class="page-link" href="?'.http_build_query($CurrentQuery).'">'.$Loop.'</a></li>';
                    } else $PagedHTML .= '<li class="page-item"><a class="page-link" href="?'.http_build_query($CurrentQuery).'">'.$Loop.'</a></li>';
                }

                $PageBreak++;
                $Loop++;
            }

            if ($CurrentPage < ($TotalPage - ($LimitPage / 2))) 
            {
                $CurrentQuery['Page'] = $TotalPage;

                $PagedHTML .= '<li class="page-item"><a class="page-link"  href="?'.http_build_query($CurrentQuery).'">...</a></li>';
                $PagedHTML .= '<li class="page-item"><a class="page-link" href="?'.http_build_query($CurrentQuery).'">'.$TotalPage.'</a></li>';
            }
        }

        return $PagedHTML.$NextButton.$LastButton;
    }
    function GetProductList($CurrentPage){
        $sql = "SELECT * FROM book WHERE id != 0 ";
        if ($CurrentPage !== 0)
        {
            $sql .= " GROUP BY id order by id desc";
        }
        return $this->result1(0,$sql);
    }
    
    function getLastestIdProduct(){
        $sql = "SELECT id as lastid FROM book ORDER BY id DESC LIMIT 1";
        return $this->result1(1,$sql)['lastid'];
    }

    function countProductByIdcate($id) {
        $sql = "SELECT count(*) AS sodong FROM book where idcate = ?";
        return $this->result1(1,$sql, $id)['sodong'];
    }

    function checkIsHavePart($id){
        $sql ="SELECT count(*) AS soluong  FROM book WHERE part = ?";
        return $this->result1(1,$sql, $id)['soluong'];
    }

    function getSlugById($id){
        $sql = "SELECT slug FROM book WHERE id=?";
        return $this->result1(1,$sql,$id)['slug'];
    }

    function getIdByPart($part){
        $sql = "SELECT id FROM book WHERE part=?";
        return $this->result1(1,$sql,$part)['id'];
    }

    function getAllLinkSingle(){
        $sql = "SELECT name FROM linksingle";
        return $this->result1(0,$sql);
    }
}