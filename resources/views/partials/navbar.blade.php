<nav class="navbar navbar-expand-sm bg-blue navbar-dark position-relative mt-3 mb-4 shadow-warning">
  <div class="container">
    <a class="navbar-brand" href="#"><img src="{{asset('images/logo.jfif')}}" height="80" class="rounded-circle position-absolute" style="top:-0.4em;"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse text-end" id="collapsibleNavbar" style="margin-left:5em;">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#"><i class="fa-solid fa-chart-column"></i> Dashboard</a>
        </li>
         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="fa-solid fa-book"></i> Catalog</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="catalog"><i class="fa-solid fa-book-medical"></i> Add Book Information</a></li>
            <li><a class="dropdown-item" href="booklist"><i class="fa-solid fa-pen-to-square"></i> Update Book Information</a></li>
          </ul>
        </li>
       <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="fa-brands fa-whmcs"></i> Manage</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="publisher"><i class="fa-solid fa-laptop-file"></i> Publisher</a></li>
            <li><a class="dropdown-item" href="author"><i class="fa-solid fa-user"></i> Author</a></li>
            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-table-list"></i> Category</a></li>
          </ul>
        </li>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"><i class="fa-solid fa-arrows-spin"></i> Circulation</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-hand-point-right"></i> Borrow Book</a></li>
            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-hand-point-left"></i> Return Book</a></li>
            <li><a class="dropdown-item" href="#"><i class="fa-solid fa-calendar-check"></i> Reservation</a></li>
          </ul>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
         <button class="btn btn-sm btn-warning text-blue rounded-pill"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
        </li>
       
      </ul>
    </div>
  </div>
</nav>