<?php
include '../functions.php';
global $connection;
$user_id= $_SESSION['users_id'];
 $categoria_serial = $_POST['autore'];
 $category = $_POST['category'];

 
 if($category==null || $category=='tutto'){
    $concacategoria="";
 
 }else {
    $concacategoria=" AND video_con_category.id_category='$category'";
  
 }
 
               //if  the category do not came 

 
$data = array();
        //this make the sum and find all the datas required  at the same time  for the  specific datas
 $query= "SELECT *,(SELECT AVG(rating) AS Rating FROM video_rating WHERE video_rating.video_id = video_con_category.id_video ) as Rating , (SELECT COUNT(video_views.id_views) AS ViewTot FROM video_views WHERE video_views.id_video = video_con_category.id_video ) as ViewTot FROM video_con_category INNER JOIN videos ON video_con_category.id_video=videos.id_video JOIN autore_video ON videos.autore=autore_video.id_autore JOIN video_category ON video_con_category.id_category = video_category.id_category  WHERE  videos.id_serial='$categoria_serial' AND videos.super_categorie=3 ". $concacategoria."  GROUP BY videos.id_video";
 $result = mysqli_query($connection,$query);
    while($row=mysqli_fetch_array($result)){

        $data[] = array(
            'id_video' => $row['id_video'], 
            'title_video' => $row['title_video'], 
            'autore' =>  $row['nome_autore']." ".$row['cognome_autore'],
            'data_creation' => date('H:m:s d-m-Y',strtotime($row['data_creation'])),
            'rating' => round($row['Rating']),
            'path' => $row['photo_from_video'],
            'description_video' => $row['description_video'],
            'tipologia_video' => $row['tipologia_video'],
            'category_video' => $row['category_video'],
            'super_categorie' => $row['super_categorie'],
            'id_category' => $row['id_category'],
            'id_autore' => $row['id_autore'],
            
          
        );
    }

echo json_encode($data); 
//echo $query;
