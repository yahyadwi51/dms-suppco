<style type="text/css">
    @import url('https://fonts.googleapis.com/css2?family=Delicious+Handrawn&family=Poppins&family=IM+Fell+DW+Pica&family=Alkatra&family=DynaPuff&family=Playfair+Display+SC&family=Rubik+Wet+Paint&family=Copse:wght@500&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Rye&display=swap');
    .content{
        height:75vh;
    }
    .konten{
        background-image: linear-gradient(rgba(0,0,0,0.80),rgba(0,0,0,0.70)), url('assets2/images/icons/1.gif'); 
        background-position: center; 
        background-size: cover;
    }
    #cs{
        font-size: 60px;
        font-family: 'Rye', cursive;
        color: #9999ff;
    }
    #cst{
        font-size: 18px;
        font-family: 'IM Fell DW Pica', serif;
        color: #00ffff;
    }
    #csi{
        font-size: 17px;
        font-family: 'IM Fell DW Pica', serif;
        color: #00e6f0;
        /* text-decoration-line: underline; */
    }
    svg {
        display: block;
        font: 7em'Rye', cursive;
        margin: 0 auto;
    }
    .text-copy {
        fill: none;
        stroke: #7373ff;
        stroke-dasharray: 6% 29%;
        stroke-width: 5px;
        stroke-dashoffset: 0%;
        animation: stroke-offset 5.5s infinite linear;
    }

    .text-copy:nth-child(1){
        stroke: #0099c2;
        animation-delay: -1;
    }

    .text-copy:nth-child(2){
        stroke: #0099c2;
        animation-delay: -2s;
    }

    .text-copy:nth-child(3){
        stroke: #00b2d1;
        animation-delay: -3s;
    }

    .text-copy:nth-child(4){
        stroke: #00cce0;
        animation-delay: -4s;
    }

    .text-copy:nth-child(5){
        stroke: #004c94;
        animation-delay: -5s; 
    }


    @keyframes stroke-offset{
        100% {stroke-dashoffset: -35%;}
    }
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Perkara</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo base_url()?>">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $maintenance ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content konten">
      <div class="container-fluid">
        <div class="row">
            <div class="mt-5">
                <svg viewBox="0 0 960 300" class="pt-5">
                    <symbol id="s-text">
                        <text text-anchor="middle" x="50%" y="80%">Coming Soon</text>
                    </symbol>
                    
                    <g class="g-ants">
                        <use xlink:href="#s-text" class="text-copy"></use>
                        <use xlink:href="#s-text" class="text-copy"></use>
                        <use xlink:href="#s-text" class="text-copy"></use>
                        <use xlink:href="#s-text" class="text-copy"></use>
                        <use xlink:href="#s-text" class="text-copy"></use>
                        <use xlink:href="#s-text" class="text-copy"></use>
                        <use xlink:href="#s-text" class="text-copy"></use>
                        <use xlink:href="#s-text" class="text-copy"></use>
                    </g>
                </svg>
                
                <p id="cst" class="mt-1 text-center">Submenu <?php echo $maintenance ?> sedang dalam tahap pengembangan <br>oleh tim IT kantor direksi PT. Perkebunan Nusantara XII.</p>
                <p id="csi" class="mt-1 text-center">Hubungi Subbagian TI untuk informasi lebih lanjut.</p>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
