
<style>
.footer{
  background: #152F4F;
  color:white;
  position:absolute;
  left:0;
  right:0;

  .links{
    ul {list-style-type: none;}
    li a{
      color: white;
      transition: color .2s;
      &:hover{
        text-decoration:none;
        color:#4180CB;
        }
    }
  }
  .about-company{
    i{font-size: 25px;}
    a{
      color:white;
      transition: color .2s;
      &:hover{color:#4180CB}
    }
  }
  .copyright p{border-top:1px solid rgba(255,255,255,.1);}
}

</style>

<div class="mt-5 pt-5 pb-5 footer ">
    <div class="container">
      <div class="row ">

        <div class="col-lg-4 col-xs-12 location" style="margin-left: 46px;">
            <h4 class="mt-lg-0 mt-sm-4">Location</h4>
            <p>tétouan shore, Tétouan 93000</p>
        </div>

        <div class="col-lg-4 col-xs-12 links">
            <h4 class="mt-lg-0 mt-sm-4">Contact</h4>
            <p class="mb-0"><i class="fas fa-phone-volume fa-md"></i>     05397-07402</p>
            <p><i class="fas fa-envelope fa-md"></i>     infos@ismo.ma</p>
        </div>

        <div class="col-lg-3 col-xs-12 about-company " style="text-align: right;">
            <h4>Connect</h4>
            <!-- Facebook -->
            <a
            class="btn rounded-circle btn-floating m-1 btn-social-icon btn-facebook"
            style="background-color: #84c9f7;"
            href="https://www.facebook.com/ismo.tet/"
            role="button"
            ><i class="fab fa-facebook-f" style="color: rgb(250, 248, 248)"></i
            ></a>

            <!-- Google -->
            <a
            class="btn  rounded-circle btn-floating m-1"
            style="background-color: #dd4b39;"
            href="http://www.ismo.ma/"
            role="button"
            ><i class="fab fa-google" style="color: rgb(250, 248, 248)"></i
            ></a>
            </div>

      </div>
      <hr/>

        <div class="col-lg-5 " style="margin-left: 496px;">
            <div class="col copyright position-absolute ">
                <h4 ><small class="text-white-50"> © 2021 Copyright:</small>
                    <a class="text-white" href="http://www.ismo.ma/">ismo.ma</a>
                </h4>
            </div>
        </div>
    </div>
</div>
