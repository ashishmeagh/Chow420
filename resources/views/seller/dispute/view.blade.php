
@extends('buyer.layout.master')
@section('main_content')

<div class="my-profile-pgnm">Dispute Chat</div>
<div class="new-wrapper">
<div class="order-main-dvs disputechat-main">
  <div class="message-main">
                        <div class="dash-white-main">
                            <div data-responsive-tabs class="verticalslide">
                                <nav>
                                    <div class="search-member-block">
                                        <input type="text" name="Search" placeholder="Search" />
                                        <button type="submit"><img src="{{url('/')}}/assets/buyer/images/message-search-icon.png" alt="" /> </button>
                                    </div>
                                    <ul class="content-d">
                                        <li>
                                            <a href="#tabone">
                                                <span class="travles-img active">
                                                    <span class="travles-green"></span>
                                                    <img src="{{url('/')}}/assets/buyer/images/commment-profile-lg.jpg" alt="" />
                                                </span>
                                                <span class="travles-name-blo">
                                                    <span class="travles-name-head"> Hays </span>
                                                    <span class="travles-name-sub"> Hotel Manager</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#tabtwo">
                                                <span class="travles-img active">
                                        <span class="travles-green"></span>
                                                <img src="{{url('/')}}/assets/buyer/images/commment-profile-lg2.jpg" alt="" />
                                                </span>
                                                <span class="travles-name-blo">
                                                   <span class="travles-name-head"> Azumano </span>
                                                <span class="travles-name-sub"> Civil Engineer</span>
                                                </span>
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#tabthree">
                                                <span class="travles-img">
                                                    <span class="travles-green"></span>
                                                    <img src="{{url('/')}}/assets/buyer/images/menu-user-icon.png" alt="" />
                                                </span>
                                                <span class="travles-name">BCD Travel</span>
                                            </a>
                                        </li>

                                       
                                    </ul>
                                </nav>
                                <div class="chat-travels-name">
                                    Azumano
                                </div>
                                <div class="content">
                                    <section id="tabone">
                                        <div class="messages-section-main">
                                            <div class="left-message-block">
                                                <div class="left-message-profile-main">
                                                    <div class="left-message-profile">
                                                        <img src="{{url('/')}}/assets/buyer/images/commment-profile-lg.jpg" alt="" />
                                                    </div>
                                                </div>
                                                <div class="left-message-content">
                                                    <img src="{{url('/')}}/assets/buyer/images/message-arrow-left.png" alt="" class="arrow-message-left" />
                                                    <div class="actual-message">
                                                        Nanti kita technical meeting lomb..
                                                    </div>
                                                    <div class="message-time">
                                                        03 Jan, 12:30 am
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="left-message-block right-message-block">
                                                <div class="rights-message-profile">
                                                    <div class="left-message-profile">
                                                        <img src="{{url('/')}}/assets/buyer/images/commment-profile-lg2.jpg" alt="" />
                                                    </div>
                                                </div>
                                                <div class="left-message-content">
                                                    <img src="{{url('/')}}/assets/buyer/images/message-arrow-right.png" alt="" class="arrow-message-right" />
                                                    <div class="actual-message">
                                                        Semua satu team ITone yang berangkat ke ja?
                                                    </div>
                                                    <div class="message-time">
                                                        03 Jan, 12:30 am
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="left-message-block">
                                                <div class="left-message-profile-main">
                                                    <div class="left-message-profile">
                                                        <img src="{{url('/')}}/assets/buyer/images/menu-user-icon.png" alt="" />
                                                    </div>
                                                </div>
                                                <div class="left-message-content">
                                                    <img src="{{url('/')}}/assets/buyer/images/message-arrow-left.png" alt="" class="arrow-message-left" />
                                                    <div class="actual-message">
                                                        Iya,semua kita berangkat pake pesawat biar cepet dari jakarta berangkat, terus dari
                                                    </div>
                                                    <div class="message-time">
                                                        04 Jan, 12:30 am
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="left-message-block right-message-block">
                                                <div class="rights-message-profile">
                                                    <div class="left-message-profile">
                                                        <img src="{{url('/')}}/assets/buyer/images/menu-user-icon.png" alt="" />
                                                    </div>
                                                </div>
                                                <div class="left-message-content">
                                                    <img src="{{url('/')}}/assets/buyer/images/message-arrow-right.png" alt="" class="arrow-message-right" />
                                                    <div class="actual-message">
                                                        Ok,berarti kita beberpa hari disana?
                                                    </div>
                                                    <div class="message-time">
                                                        04 Jan, 12:30 am
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="left-message-block">
                                                <div class="left-message-profile-main">
                                                    <div class="left-message-profile">
                                                        <img src="{{url('/')}}/assets/buyer/images/commment-profile-lg.jpg" alt="" />
                                                    </div>
                                                </div>
                                                <div class="left-message-content">
                                                    <img src="{{url('/')}}/assets/buyer/images/message-arrow-left.png" alt="" class="arrow-message-left" />
                                                    <div class="actual-message">
                                                        Yaiyalah tenang kita tidur di hotel ko
                                                    </div>
                                                    <div class="message-time">
                                                        03 Jan, 12:30 am
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="left-message-block right-message-block">
                                                <div class="rights-message-profile">
                                                    <div class="left-message-profile">
                                                        <img src="{{url('/')}}/assets/buyer/images/menu-user-icon.png" alt="" />
                                                    </div>
                                                </div>
                                                <div class="left-message-content">
                                                    <img src="{{url('/')}}/assets/buyer/images/message-arrow-right.png" alt="" class="arrow-message-right" />
                                                    <div class="actual-message">
                                                        Sip lumayan seklian jalan jalan, semoga tim kita menang
                                                    </div>
                                                    <div class="message-time">
                                                        03 Jan, 12:30 am
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="left-message-block">
                                                <div class="left-message-profile-main">
                                                    <div class="left-message-profile">
                                                        <img src="{{url('/')}}/assets/buyer/images/commment-profile-lg.jpg" alt="" />
                                                    </div>
                                                </div>
                                                <div class="left-message-content">
                                                    <img src="{{url('/')}}/assets/buyer/images/message-arrow-left.png" alt="" class="arrow-message-left" />
                                                    <div class="actual-message">
                                                        Yaiyalah tenang kita tidur di hotel...
                                                    </div>
                                                    <div class="message-time">
                                                        03 Jan, 12:30 am
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </section>
                                    <section id="tabtwo">
                                        <h3>Section 2</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur deleniti, odio quibusdam laboriosam cupiditate quo repellendus iure optio ea maiores tempore voluptatibus omnis temporibus nemo, a natus repudiandae nulla excepturi.</p>
                                    </section>
                                    <section id="tabthree">
                                        <h3>Section 3</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur deleniti, odio quibusdam laboriosam cupiditate quo repellendus iure optio ea maiores tempore voluptatibus omnis temporibus nemo, a natus repudiandae nulla excepturi.</p>
                                    </section>
                                    <section id="tabfour">
                                        <h3>Section 4</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur deleniti, odio quibusdam laboriosam cupiditate quo repellendus iure optio ea maiores tempore voluptatibus omnis temporibus nemo, a natus repudiandae nulla excepturi.</p>
                                    </section>
                                    
                                </div>
                                <div class="clear"></div>
                                <div class="write-message-block">
                                    <input type="text" name="write a replay" placeholder="Typeing..." />
                                    <div class="disput-popup">
                                        <div class="fileUpload">
                                            <span><i class="fa fa-paperclip"></i></span>
                                            <input type="file" class="upload" />
                                        </div>
                                    </div>
                                    <button class="send-message-btn" type="submit"><i class="fa fa-paper-plane"></i></button>
                                </div>
                                <div class="clr"></div>
                            </div>
                        </div>
                    </div>
</div>
</div>
@endsection
