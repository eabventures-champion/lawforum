{{--<footer style="text-align: center;">
    <div class="row" style="display: inline-block;">
        <div class="col-md-4">
            <ul style="list-style: none;">
            <h4>Use {{ setting('site.title') }}</h4>
                <li><a href="#">About Us</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">How it works</a></li>
                <li><a href="#">Pricing</a></li>
                <li><a href="#">Blog</a></li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul style="list-style: none;">
            <h4>Find Laws</h4>
            <li><a href="#">Browse Laws</a></li>
            <li><a href="#">Get the {{ setting('site.title') }} App</a></li>
            </ul>
        </div>
        <div class="col-md-4">
            <ul style="list-style: none;">
            <h4>Connect With Us</h4>
                <li><a href="#">Report any issues</a></li>
                <li><a href="#">Get Help</a></li>
                <li><a href="#">Our Terms</a></li>
                <li><a href="#">Privacy</a></li>
            </ul>
        </div>
        <div class="col-md-12 pull-right" style="padding-top: 10px;">
            <p>&copy;2019. Powered by <a href="/">{{ setting('site.title') }}</a></p>
        </div>
    </div>
</footer>
--}}

<!-- for the ads -->
<div class="col-md-12" style="background-color:#ffffff; height:100px; margin-top:80px;"></div>

<!-- for the footer -->
<div id="footer_div" class="col-md-12 bg-header-color" style="height:36px;">
    <ul id="footer_ul">
        
        @foreach($footer_notes as $caption)
        |&nbsp;&nbsp;<li style="display: inline-block"><a style="color: #ffffff;" href="/caption/{{$caption->name}}/{{$caption->id}}">{{ $caption->name }}</a></li>&nbsp;&nbsp;
        @endforeach
        |&nbsp;&nbsp;<li style="display: inline-block"><a style="color: #60a5fa; font-weight: bold;" href="{{ route('admin.login') }}">Admin Portal</a></li>&nbsp;&nbsp;
    </ul>
</div>