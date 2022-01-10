<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css.scss">
    <link href='https://fonts.googleapis.com/css?family=Sacramento:400' rel='stylesheet' type='text/css'>
    <title>Cyclic table</title>
</head>
<body>
    <div>    
        <form action="" method="GET">
                <h1>REDAK</h1>
            <input  type="number" name="row" value="row">
                <h1>STUPAC</h1>
            <input  type="number" name="col" value="col">
                <br>
            <input class="button" type="submit" value="CREATE TABLE">
        </form>
        
<?php 

if(isset($_GET['row']))
{
    $row=$_GET['row'];
    $col=$_GET['col'];
    $xRow=$row-1;
    $xCol=$col-1;
    $yCol=0;
    $yRow=0;
    $p=1;
    $matrix=[];
    for ($r=$p; $r < $row*$col;) 
            {
                for($j=$xCol; $j >= $yCol; $j--)
                {
                    $matrix[$xRow][$j] = $p++;
                }
                    $xRow--;
                    if ($p > $row*$col) break;

                for ($i=$xRow; $i >= $yRow ;$i--) 
                { 
                    $matrix[$i][$yCol] = $p++;
                }
                    $yCol++;
                    if ($p > $row*$col) break;

                for ($j=$yCol; $j <= $xCol; $j++) 
                { 
                    $matrix[$yRow][$j] = $p++;
                }
                    $yRow++;
                    if ($r > $row*$col) break;
                for ($i=$yRow; $i <= $xRow; $i++) 
                { 
                    $matrix[$i][$xCol] = $p++;
                }
                    $xCol--;    
            
            }
echo '<table>';

for($i=0;$i<$row;)
{
echo '<tr>';
for ($j=0; $j < $col;) 
{ 
echo '<td>'. $matrix[$i][$j] .'</td>';
$j++;
}
echo '</tr>';
$i++;
} 
echo '</table>';   
}

?>

    </div>
</body>
</html>