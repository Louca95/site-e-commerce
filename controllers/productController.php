<?php
    include_once __DIR__ . '/../database/db.php';

function getAllProducts() {
  // requetes sql pour chopper tous les produits
  global $conn;
    try {
        $query = "SELECT * FROM product";
        $result = $conn->query($query);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Erreur lors de la récupération des produits: " . $e->getMessage();
        return null;
    }
}

function home() {
  $products = getAllProducts();
  include 'views/index.php';
}

function getProductById($id) {
  global $conn, $baseUri;
  try {
      $query = "SELECT * FROM products WHERE id = :id";
      $result = $conn->prepare($query);
      $result->bindParam(':id', $id);
      $result->execute();
      return $result->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
      echo "Erreur lors de la récupération du produit: " . $e->getMessage();
      return null;
  }
}

function viewProduct() {
  if (isset($_GET['id'])) {
      $id = intval($_GET['id']);
      $product = getProductById($id);
      
      if (!$product) {
          include __DIR__ . '/../views/404.php'; // Produit non trouvé
      } else {
          include __DIR__ . '/../views/product.php'; // Afficher les détails du produit
      }
  } else {
      include __DIR__ . '/../views/404.php'; // ID non fourni
  }
}





?>