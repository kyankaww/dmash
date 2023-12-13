<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html">Koperasi</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">KP</a>
      </div>
      <ul class="sidebar-menu">
          <li class=" <?= $page == 'dashboard' ? 'active' : '' ?> "><a class="nav-link" href="/dashboard"><i class="far fa-home"></i> <span>Dashboard</span></a></li>
          <li class=" <?= $page == 'user' ? 'active' : '' ?> "><a class="nav-link" href="/user"><i class="far fa-user"></i> <span>User</span></a></li>
          <li class=" <?= $page == 'product' ? 'active' : '' ?> "><a class="nav-link" href="/product"><i class="far fa-bag-shopping"></i> <span>Product</span></a></li>
          <li class=" <?= $page == 'category' ? 'active' : '' ?> "><a class="nav-link" href="/category"><i class="far fa-dot-circle"></i> <span>Category</span></a></li>
          <li class=" <?= $page == 'cart' ? 'active' : '' ?> "><a class="nav-link" href="/cart"><i class="far fa-shopping-cart"></i> <span>Cart</span></a></li>
          <li class=" <?= $page == 'order' ? 'active' : '' ?> "><a class="nav-link" href="/order"><i class="far fa-bill"></i> <span>Order</span></a></li>
          <li class=" <?= $page == 'payment' ? 'active' : '' ?> "><a class="nav-link" href="/payment"><i class="far fa-bill"></i> <span>Payment</span></a></li>
        </ul>

    </aside>
  </div>