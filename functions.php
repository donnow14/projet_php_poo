<?php 
function GetStudentsN($conn){ 
    $result = User::CountUsers("users",$conn);
    return $result;
}

function GetProfsN($conn){ 
    $result = Prof::CountUsers("profs",$conn);
    return $result;
}
function GetCoursN($conn){ 
    $result = Cours::CountCours("cours",$conn);
    return $result;
}
function GetCommentsN($conn){ 
    $result = Comment::CountComments("comments",$conn);
    return $result;
}
function GetStudents($conn){
    $students = User::selectAllStudents("users",$conn);
	if(!empty($students)){
		foreach($students as $row){
			$full_name = $row['full_name'];
			$email = $row['email'];
			$pic = $row['avatar'];
			if($pic === null){
				$pic = "default.png";
			}
			echo "<tr>
			<td width=\"60px\">
				<div class=\"imgBx\"><img src=\"profil/$pic\" ></div>
			</td>
			<td>
				<h4>$full_name <br> <span>$email</span></h4>
			</td>
		</tr>";
		}
	}
}
function GetcoursPr($conn,$prof){
    $cours = Cours::getCoursID("cours",$conn,$prof);
    if(!empty($cours)){
        foreach($cours as $row){
            $cour_id = $row['id'];
            $cour_name = $row['name'];
            $prof_id = $row['prof'];
            $pdf_name = $row['pdf_name'];
            $time = $row['added_time'];
            $prof_name = Prof::getnamebyid("profs",$conn,$prof_id);
            echo "<tr>
            <td>$cour_name</td>
            <td style=\"text-align:center;\">$time</td>
            <td>$prof_name</td>
            <td><a target=\"_blank\" href=\"pdf/$pdf_name\">Pdf</a></td>
            <td><a class ='' href='cours_delete.php?id=$cour_id'>Delete</a></td>
            </tr>";
        }
    }else{
        echo '<tr><td colspan="5" style="text-align:center;">You dont have any courses !</td></tr>';
    }
    
    
}
function Getcours($conn){
    $cours = Cours::showCours("cours",$conn);
	if(!empty($cours)){
		foreach($cours as $row){
			$cour_id = $row['id'];
			$cour_name = $row['name'];
			$prof_id = $row['prof'];
			$pdf_name = $row['pdf_name'];
			$time = $row['added_time'];
			$prof_name = Prof::getnamebyid("profs",$conn,$prof_id);
			echo "<tr>
			<td>$cour_name</td>
			<td style=\"text-align:center;\">$time</td>
			<td>$prof_name</td>
			<td><a target=\"_blank\" href=\"pdf/$pdf_name\">Pdf</a></td>
			<td><a class ='' href='cours_page.php?id=$cour_id'>Open</a></td>
			</tr>";
		}
	}
}

function Getcomments($conn,$cours_id){
    $comments = Comment::getComments("comments",$conn,$cours_id);
    if(isset($comments)){
        foreach($comments as $row){
            $commentor_id = $row['commentor_id'];
            $commentor_name = User::getnamebyid("users",$conn,$commentor_id);
            $content = $row['content'];
            $commentor_pic = User::getavatarbyid("users",$conn,$commentor_id);
            echo '<div class="profile-container comment">';
            echo '    <img src="./profil/' . $commentor_pic . '" alt="Profile Picture" class="profile-pic" width="80" height="80">';
            echo '    <div style="width: 100%;">';
            echo '        <h2>' . $commentor_name . '</h2><br><p> ' . $content . '</p>';
            echo '    </div>';
            echo '</div>';
        }
    }
}


























?>