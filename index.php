<?php
require 'vendor/autoload.php';
require 'src/URLHelper.php';

use App\URLHelper;

define('PER_PAGE', 10);
$pdo = new PDO(
  "sqlite:./sqliteData/chinook.db",
  null,
  null,
  [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  ]
);
$query = "SELECT * FROM customers ";
$querycount = "SELECT count(CustomerId) as count FROM customers ";
$params = [];

$page = (int)($_GET['p'] ?? 1);
$offset = ($page - 1) * PER_PAGE;

if (!empty($_GET['q'])) {
  $query .= "WHERE Country like :Country";
  $querycount .= "WHERE Country like :Country";
  $params['Country'] = '%' . $_GET['q'] . '%';
}
$query .= " LIMIT " . PER_PAGE . " OFFSET " . $offset;

$statmentcount = $pdo->prepare($querycount);
$statmentcount->execute($params);
$statmentcount->execute();
$count = (int)$statmentcount->fetch()['count'];

$statment = $pdo->prepare($query);
$statment->execute($params);
$customers = $statment->fetchAll();

$nbpages = ceil($count / PER_PAGE);
//dd($nbpages);




$title = "Home";
require "elements/header.php";
?>

<div class="container">


  <h2>Gest Book </h2>
  <form action="">
    <div class="form-group">
      <input type="search" class="form-control" value="<?= htmlentities($_GET['q'] ?? '') ?>" name="q" placeholder="Recherche..." />
    </div>
    <div class="form-group">
      <button class="btn btn-primary">
        Recherche
      </button>
    </div>


  </form>



  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">FirstName</th>
        <th scope="col">LastName</th>
        <th scope="col">Country</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php foreach ($customers as $customer) : ?>
          <th scope="row"><?= $customer['CustomerId'] ?></th>
          <td><?= $customer['FirstName'] ?></td>
          <td><?= $customer['LastName'] ?></td>
          <td><?= $customer['Country'] ?></td>
      </tr>
    <?php endforeach ?>
    </tbody>
  </table>
  <?php if ($nbpages > 1 && $page < $nbpages) :   ?>
    <a href=".?<?= URLHelper::withParam("p", ($page + 1)) ?>">Page suivante</a>

  <?php endif  ?>


  <?php if ($nbpages > 1 && $page < $nbpages) : ?>

    <?php for ($i = 1; $i <= $nbpages; $i++) : ?>
      <?php if ($page === $i) : ?>
        <?= $i ?>


      <?php else :   ?>
        <a href=".?<?= URLHelper::withParam("p", ($i)) ?>"><?= $i ?></a>

      <?php endif  ?>

    <?php endfor ?>


  <?php endif  ?>


  <?php // if ($nbpages > 1 && $page > 1 ) :   
  ?>
  <?php if ($page > 1 && $page <= $nbpages) :   ?>
    <a href=".?<?= URLHelper::withParam("p", ($page - 1)) ?>">Page précedente</a>

  <?php endif  ?>



</div>
<?php
require "elements/footer.php";
?>