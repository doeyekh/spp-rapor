<div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li> 

            <li>
                <a class="nav-link" href="<?= site_url(); ?>home">
                    <i class="fas fa-pencil-ruler"></i> 
                    <span>Dashboard</span>
                </a>
            </li>
            <?php 
            if(in_array('Operator',userLevel()) || in_array('Administrator',userLevel()) || in_array('Kepala Sekolah',userLevel()) ): 
            ?>
            <li class="menu-header">Master Data</li>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-plug"></i> <span>Data Master</span></a>
                <ul class="dropdown-menu">
                <?php 
                  if(in_array('Administrator',userLevel())): 
                  ?>
                  <li><a class="nav-link" href="<?= site_url(); ?>tahun-ajar">Tahun Pelajaran</a></li>
                  <li><a class="nav-link" href="<?= site_url(); ?>jenjang">Jenjang</a></li>
                  <li><a class="nav-link" href="<?= site_url(); ?>ref-kelas">Referensi Kelas</a></li>
                  <li><a class="nav-link" href="<?= site_url(); ?>kurikulum">Referensi Kurikulum</a></li>
                  <li><a class="nav-link" href="<?= site_url(); ?>lembaga">Lembaga</a></li>
                  <?php 
                  endif;
                  if(in_array('Operator',userLevel()) || in_array('Kepala Sekolah',userLevel())): 
                  ?>
                  <li><a class="nav-link" href="<?= site_url(); ?>kelas">Kelas</a></li>
                  <?php endif; ?>
                </ul>
              </li>
              <?php 
            endif; 
            ?>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-plug"></i> <span>Guru</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?= site_url(); ?>guru-ak">Guru</a></li>
                  <?php 
                  if(in_array('Operator',userLevel()) || in_array('Administrator',userLevel()) || in_array('Kepala Sekolah',userLevel())):
                  ?>
                  <li><a class="nav-link" href="<?= site_url(); ?>wakasek">Wakasek</a></li>
                  <li><a class="nav-link text-danger" href="<?= site_url(); ?>guru-non">Non Aktif</a></li>
                  <?php 
                  endif 
                  ?>
                </ul>
              </li>
              <?php 
                  if(in_array('Operator',userLevel()) || in_array('Administrator',userLevel()) || in_array('Kepala Sekolah',userLevel())):
              ?>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-plug"></i> <span>Siswa</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?= site_url(); ?>siswa-ak">Aktif</a></li>
                  <li><a class="nav-link" href="<?= site_url(); ?>berkas">Berkas Siswa</a></li>
                  <li><a class="nav-link text-danger" href="<?= site_url(); ?>siswa-non">Non Aktif</a></li>
                </ul>
              </li>
              <?php 
                  endif 
                  ?>
                  <?php 
                  if(in_array('Bendahara',userLevel())):
              ?>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-plug"></i> <span>Pembiayaan</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?= site_url(); ?>Daftar-pembiayaan">Daftar Pembiayaan</a></li>
                  <li><a class="nav-link" href="<?= site_url(); ?>setting-pembiayaan">Setting Pembiayaan</a></li>
                  <li><a class="nav-link text-danger" href="<?= site_url(); ?>transaksi">Transaksi</a></li>
                </ul>
              </li>
                  
              <?php 
                  endif 
                  ?>
                  <?php 
                  if(in_array('Tata Usaha',userLevel())):
              ?>
              <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-plug"></i> <span>Arsip</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="<?= site_url(); ?>surat-masuk">Surat Masuk</a></li>
                  <li><a class="nav-link" href="<?= site_url(); ?>surat-keluar">Surat Keluar</a></li>
                </ul>
              </li>
                  
              <?php 
                  endif 
                  ?>
              <li>
                <a class="nav-link" href="<?= site_url(); ?>profil">
                    <i class="fas fa-pencil-ruler"></i> 
                    <span>Profil</span>
                </a>
              </li>
              
            </ul>

            
        </aside>
      </div>