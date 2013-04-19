--TEST--
Simple sub-select
--FILE--
<?php
include_once dirname(__FILE__) . "/connect.inc.php";
/* @var $fpdo FluentPDO */

$subquery = $fpdo->from('article')->select(null)->select('COUNT(id)')->where('user_id', new FluentLiteral('user.id'));

$query = $fpdo->from('user')->select($subquery)->where('id', 1);

echo $query->getQuery() . "\n\n";
print_r($query->getParameters()) . "\n";

?>
--EXPECTF--
SELECT user.*, (SELECT COUNT(id)
FROM article
WHERE user_id = ?)
FROM user
WHERE id = ?

Array
(
    [0] => FluentLiteral Object
        (
            [value:protected] => user.id
        )

    [1] => 1
)
