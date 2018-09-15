<?php
require_once 'core/init.php';

/*
    if(isset($_GET["data"])){
        if($_GET["data"] == '1'){
            echo json_encode(["data"=>"Given an array of  integers, can you find the sum of its elements?

Input Format

The first line contains an integer, , denoting the size of the array. 
The second line contains  space-separated integers representing the array's elements.

Output Format

Print the sum of the array's elements as a single integer.

Sample Input

6
1 2 3 4 10 11
Sample Output

31"]);
        }
        else if($_GET["data"] == '2'){
            echo json_encode(["data"=>"Alice and Bob each created one problem for HackerRank. A reviewer rates the two challenges, awarding points on a scale from  to  for three categories: problem clarity, originality, and difficulty.

We define the rating for Alice's challenge to be the triplet , and the rating for Bob's challenge to be the triplet .

Your task is to find their comparison points by comparing  with ,  with , and  with .

If , then Alice is awarded  point.
If , then Bob is awarded  point.
If , then neither person receives a point.
Comparison points is the total points a person earned.

Given  and , can you compare the two challenges and print their respective comparison points?

Input Format

The first line contains  space-separated integers, , , and , describing the respective values in triplet . 
The second line contains  space-separated integers, , , and , describing the respective values in triplet .

Constraints

Output Format

Print two space-separated integers denoting the respective comparison points earned by Alice and Bob.

Sample Input

5 6 7
3 6 10
Sample Output

1 1 "]);
        }
        else if($_GET["data"] == '3'){
            echo json_encode(["data"=>"Hello question this is question 3."]);
        }
        else if($_GET["data"] == '4'){
            echo json_encode(["data"=>"Hello question this is question 4."]);
        }
    }

*/

if (Input::exists('get')) {
    $data = Input::get("data");
    if(isset($data)){
        $question = file_get_contents('./Questions/'.Input::get("data").'.question');
        $sample = file_get_contents('./Questions/'.Input::get("data").'.sample');
        //var_dump($question);
        echo json_encode(["data" => $question, "sample"=>$sample]);
        //var_dump($question);
    }/*elseif(Input::get("data") == 2){
        $question = file_get_contents('./Questions/2.question');
        $sample = file_get_contents('./Questions/2.sample');
        echo json_encode(["data" => $question, "sample"=>$sample]);
    }*/
}


?>