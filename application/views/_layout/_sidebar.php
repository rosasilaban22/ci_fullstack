<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

 

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">MENU</li>
      <!-- Optionally, you can add icons to the links -->
      <li><a href="<?php echo base_url(); ?>home"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
      
      <!-- Data Master -->
      <li class="treeview">
        <a href="#"><i class="glyphicon glyphicon-th-list"></i> <span>Master Data</span><i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
        <li><a href="<?php echo base_url(); ?>kategori"><i class="fa fa-circle-o"></i> Data Kategori</a></li>
          <li><a href="<?php echo base_url(); ?>satuan"><i class="fa fa-circle-o"></i> Data Satuan</a></li>
        </ul>
      </li>
      <!-- Data Produk -->
      <li><a href="<?php echo base_url(); ?>produk"><i class="fa fa-cube"></i> <span>Produk</span></a></li>
      <li><a href="<?php echo base_url(); ?>users"><i class="fa fa-user"></i> <span>Users</span></a></li>
      <li><a href="<?php echo base_url(); ?>home/logout"><i class="fa fa-sign-out"></i> <span>Log Out</span></a></li>
      <!-- Data Transaksi -->
      
    </ul>
    <!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>