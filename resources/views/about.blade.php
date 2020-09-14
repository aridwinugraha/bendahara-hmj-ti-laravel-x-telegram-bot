@extends('layouts.app')

@section('content')
@if (Auth::user()->status_anggota == 'Pengurus Harian')
    @if (Auth::user()->username_telegram != null && Auth::user()->chat_id != null)
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 ml-sm-auto col-lg-9 px-md-4">
                <div class="card shadow">
                    <div class="card-header">
                        <section id="profile-image">
                            <div class="image-container">
                                <a href="#">
                                    <img src="/images/me_1.png" alt="profil author">
                                </a>
                            </div>
                        </section>
                        <section id="profile-summary">
                            <div id="nicknames">
                            <h1 class="name"><strong>{{__('A . D . N') }}</strong></h1>
                            <h3 class="position">{{__('Author') }}</h3>
                            </div>
                        </section>
                    </div>
                    <div class="card-body">
                        <section id="about">
                            <div id="resume">
                                <h3>{{__('About') }}</h3>
                                <p>Hi, nama saya <strong>Ari Dwi Nugraha</strong>. Saya Kuliah Di <strong>STMIK Akakom Yogyakarta</strong></p>
                                <p>Web ini bertujuan untuk memudahkan bendahara organisasi khususnya <strong>HMJ-TI</strong> dalam hal iuran kas PH dan hitung, laporan kas,<br>Dalam web ini Terdapat beberapa Fitur :<br></p>
                                <li>Pengingat Bayar Iuran Kas PH Menggunakan Telegram Bot Bendaharahmjti</li>
                                <li>Laporan Kas Ph Digital(web ke excel) dan download laporan kas ph dalam bentuk file pdf</li>
                            </div>
                        </section>
                    </div>

                    <div class="card-footer">
                        <section id="social">
                            <div class="socmed">
                                <h3>{{__('Contact & Social Media') }}</h3>
                                <div class="sosmed-list">
                                    <a href="mailto:arinugraha56@gmail.com?Subject=Hello+Ari" target="_blank" rel="noopener noreferrer" aria-label="Email Ari Dwi Nugraha" style="font-size:2em;">
                                        <i class="far fa-envelope"></i>
                                    </a>
                                    <a href="https://web.facebook.com/aridwi.nugraha/" target="_blank" rel="noopener noreferrer" aria-label="Facebook Ari Dwi Nugraha" style="font-size:2em;">
                                        <i class="fab fa-facebook"></i>
                                    </a>
                                    <a href="https://twitter.com/aridwinugraha4?s=09" target="_blank" rel="noopener noreferrer" aria-label="Twitter Ari Dwi Nugraha" style="font-size:2em;">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://www.instagram.com/arinugraha56/" target="_blank" rel="noopener noreferrer" aria-label="Instagram Ari Dwi Nugraha" style="font-size:2em;">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="https://api.whatsapp.com/send?phone=+6285814487401" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp Ari Dwi Nugraha" style="font-size:2em;">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                    <a href="https://t.me/aridwi56/" target="_blank" rel="noopener noreferrer" aria-label="Telgram Ari Dwi Nugraha" style="font-size:2em;">
                                        <i class="fab fa-telegram"></i>
                                    </a>
                                    <a href="https://github.com/aridwinugraha/" target="_blank" rel="noopener noreferrer" aria-label="Github Ari Dwi Nugraha" style="font-size:2em;">
                                        <i class="fab fa-github"></i>
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="card-footer">
                        <section id="years">
                            <div class="copyrigth">
                                <p>&copy; 2020 Ari Dwi Nugraha</p>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        @include('modal')
    @endif

@else
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ml-sm-auto col-lg-9 px-md-4">
            <div class="card shadow">
                <div class="card-header">
                    <section id="profile-image">
                        <div class="image-container">
                            <a href="#">
                                <img src="/images/me_1.png" alt="profil author">
                            </a>
                        </div>
                    </section>
                    <section id="profile-summary">
                        <div id="nicknames">
                        <h1 class="name"><strong>{{__('A . D . N') }}</strong></h1>
                        <h3 class="position">{{__('Author') }}</h3>
                        </div>
                    </section>
                </div>
                <div class="card-body">
                    <section id="about">
                        <div id="resume">
                            <h3>{{__('About') }}</h3>
                            <p>Hi, nama saya <strong>Ari Dwi Nugraha</strong>. Saya Kuliah Di <strong>STMIK Akakom Yogyakarta</strong></p>
                            <p>Web ini bertujuan untuk memudahkan bendahara organisasi khususnya <strong>HMJ-TI</strong> dalam hal iuran kas PH dan hitung, laporan kas,<br>Dalam web ini Terdapat beberapa Fitur :<br></p>
                            <li>Pengingat Bayar Iuran Kas PH Menggunakan Telegram Bot Bendaharahmjti</li>
                            <li>Laporan Kas Ph Digital(web ke excel) dan download laporan kas ph dalam bentuk file pdf</li>
                        </div>
                    </section>
                </div>

                <div class="card-footer">
                    <section id="social">
                        <div class="socmed">
                            <h3>{{__('Contact & Social Media') }}</h3>
                            <div class="sosmed-list">
                                <a href="mailto:arinugraha56@gmail.com?Subject=Hello+Ari" target="_blank" rel="noopener noreferrer" aria-label="Email Ari Dwi Nugraha" style="font-size:2em;">
                                    <i class="far fa-envelope"></i>
                                </a>
                                <a href="https://web.facebook.com/aridwi.nugraha/" target="_blank" rel="noopener noreferrer" aria-label="Facebook Ari Dwi Nugraha" style="font-size:2em;">
                                    <i class="fab fa-facebook"></i>
                                </a>
                                <a href="https://twitter.com/aridwinugraha4?s=09" target="_blank" rel="noopener noreferrer" aria-label="Twitter Ari Dwi Nugraha" style="font-size:2em;">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.instagram.com/arinugraha56/" target="_blank" rel="noopener noreferrer" aria-label="Instagram Ari Dwi Nugraha" style="font-size:2em;">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="https://api.whatsapp.com/send?phone=+6285814487401" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp Ari Dwi Nugraha" style="font-size:2em;">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                                <a href="https://t.me/aridwi56/" target="_blank" rel="noopener noreferrer" aria-label="Telgram Ari Dwi Nugraha" style="font-size:2em;">
                                    <i class="fab fa-telegram"></i>
                                </a>
                                <a href="https://github.com/aridwinugraha/" target="_blank" rel="noopener noreferrer" aria-label="Github Ari Dwi Nugraha" style="font-size:2em;">
                                    <i class="fab fa-github"></i>
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="card-footer">
                    <section id="years">
                        <div class="copyrigth">
                            <p>&copy; 2020 Ari Dwi Nugraha</p>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>    
@endif
    
    @forelse ($anggota as $t)    
        @empty
            @include('modal') 
    @endforelse
@endsection