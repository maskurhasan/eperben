<style type="text/css">
    .digg_pagination {
  background: white;
  cursor: default;
  /* self-clearing method: */ }
  .digg_pagination a, .digg_pagination span, .digg_pagination em {
    padding: 0.2em 0.5em;
    display: block;
    float: left;
    margin-right: 1px; }
  .digg_pagination .disabled {
    color: #999999;
    border: 1px solid #dddddd; }
  .digg_pagination .current {
    font-style: normal;
    font-weight: bold;
    background: #2e6ab1;
    color: white;
    border: 1px solid #2e6ab1; }
  .digg_pagination a {
    text-decoration: none;
    color: #105cb6;
    border: 1px solid #9aafe5; }
    .digg_pagination a:hover, .digg_pagination a:focus {
      color: #000033;
      border-color: #000033; }
  .digg_pagination .page_info {
    background: #2e6ab1;
    color: white;
    padding: 0.4em 0.6em;
    width: 22em;
    margin-bottom: 0.3em;
    text-align: center; }
    .digg_pagination .page_info b {
      color: #000033;
      background: #6aa6ed;
      padding: 0.1em 0.25em; }
  .digg_pagination:after {
    content: ".";
    display: block;
    height: 0;
    clear: both;
    visibility: hidden; }
  * html .digg_pagination {
    height: 1%; }
  *:first-child + html .digg_pagination {
    overflow: hidden; }

</style>
<?php
function getTableData1($sql, $page = 1, $limit = 10)
{
    $dataTable = array();
    $startRow = ($page - 1) * $limit;
    $query = mysql_query($sql.' LIMIT '.$startRow.', '.$limit);
    //$query = mysql_query('SELECT * FROM `'.$tableName.'` LIMIT '.$startRow.', '.$limit);

    while ($data = mysql_fetch_assoc($query))
        array_push($dataTable, $data);

    return $dataTable;
}


function getTableData($sql,$page = 1)
{
    $limit = 10;
    $dataTable = array();
    $startRow = ($page - 1) * $limit;
    $query = mysql_query($sql.' LIMIT '.$startRow.', '.$limit);
    //$query = mysql_query('SELECT * FROM `'.$tableName.'` LIMIT '.$startRow.', '.$limit);

    while ($data = mysql_fetch_assoc($query))
        array_push($dataTable, $data);

    return $dataTable;
}



function showPagination1($sql)
{
    $limit = 10;
    $countTotalRow = mysql_query($sql);
    $queryResult = mysql_num_rows($countTotalRow);
    $totalRow = $queryResult;

    $totalPage = ceil($totalRow / $limit);

    $page = 1;
    echo '<ul class="pagination  pagination-sm no-margin pull-right">
        <li><a href="?module='.$_GET[module].'&page='.($_GET['page']-1).'">&laquo;</a></li>';
    while ($page <= $totalPage)
    {
        echo '<li><a href="?module='.$_GET[module].'&page='.$page.'">'.$page.'</a></li>';
        if ($page < $totalPage)
           echo " ";
        $page++;

    }
    echo '<li><a href="?module='.$_GET[module].'&page='.($_GET['page']+1).'">&raquo;</a></li>
        </ul>';
}

function showPagination($sql)
{
    $limit = 10;
    $countTotalRow = mysql_query($sql);
    $queryResult = mysql_num_rows($countTotalRow);
    $totalRow = $queryResult;
    $totalPage = ceil($totalRow / $limit);
    $page = 1;
    echo '<div class="digg_pagination">
        <a href="?module='.$_GET[module].'&page='.($_GET['page']-1).'">&laquo;</a> ';
    while ($page <= $totalPage)
    {
        if($_GET['page']==$page){
        echo ' <a class="current" href="?module='.$_GET[module].'&page='.$page.'">'.$page.'</a> ';
        } else {
        echo ' <a href="?module='.$_GET[module].'&page='.$page.'">'.$page.'</a> ';
        }
        if ($page < $totalPage)
           echo " ";
        $page++;

    }
    echo ' <a href="?module='.$_GET[module].'&page='.($_GET['page']+1).'">&raquo;</a>
        </div>';
}

function showPagination2($sql)
{
    $limit = 10;
    $countTotalRow = mysql_query($sql);
    $queryResult = mysql_num_rows($countTotalRow);
    $totalRow = $queryResult;
    $totalPage = ceil($totalRow / $limit);
    $page = 1;
    echo '<ul class="pagination pagination-sm no-margin pull-right">
        <li><a href="?module='.$_GET[module].'&page='.($_GET['page']-1).'">&laquo;</a></li>';
    while ($page <= $totalPage)
    {
        if($_GET['page']==$page){
        echo ' <li class="active"><a href="?module='.$_GET[module].'&page='.$page.'">'.$page.'</a></li> ';
        } else {
        echo ' <li><a href="?module='.$_GET[module].'&page='.$page.'">'.$page.'</a></li> ';
        }
        if ($page < $totalPage)
           echo " ";
        $page++;

    }
    echo ' <li><a href="?module='.$_GET[module].'&page='.($_GET['page']+1).'">&raquo;</a></li>
        </ul>';
}

function showPaginationPermohonan($sql)
{
    $limit = 10;
    $countTotalRow = mysql_query($sql);
    $queryResult = mysql_num_rows($countTotalRow);
    $totalRow = $queryResult;

    $totalPage = ceil($totalRow / $limit);

    $page = 1;
    echo '<ul class="pagination">
        <li><a href="?module='.$_GET[module].'&page='.($_GET['page']-1).'">&laquo;</a></li>';
    while ($page <= $totalPage)
    {
        echo '<li><a href="?module='.$_GET[module].'&act=utama&page='.$page.'">'.$page.'</a></li>';
        if ($page < $totalPage)
           echo " ";
        $page++;

    }
    echo '<li><a href="?module='.$_GET[module].'&page='.($_GET['page']+1).'">&raquo;</a></li>
        </ul>';
}


?>
