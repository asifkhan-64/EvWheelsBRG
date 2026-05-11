<?php
include('../_stream/config.php');
session_start();
if (empty($_SESSION["user"])) {
    header("LOCATION:../index.php");
}

include('../_partials/header.php');
?>
<div class="container my-5">
  <div class="row g-4">
    
    <!-- Product 1 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card h-100 shadow-sm">
        <img src="../assets/12.jpeg" class="card-img-top" alt="Product Name">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">Premium Product Name</h5>
          <p class="card-text text-primary fw-bold fs-5">£49.99</p>
          <div class="mt-auto">
            <a href="#" class="btn btn-dark w-100">View Details</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Product 2 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card h-100 shadow-sm">
        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product Name">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">Essential Item</h5>
          <p class="card-text text-primary fw-bold fs-5">£25.00</p>
          <div class="mt-auto">
            <a href="#" class="btn btn-dark w-100">View Details</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Product 3 -->
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card h-100 shadow-sm">
        <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Product Name">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">Modern Accessory</h5>
          <p class="card-text text-primary fw-bold fs-5">£12.50</p>
          <div class="mt-auto">
            <a href="#" class="btn btn-dark w-100">View Details</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>