<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header dis-block bg-secondary">
                <h4 class="text-center color-white">{{__('Pengumuman') }}</h4>
            </div>
            <div class="modal-body text-center">
            <p>{{__('Web ini membutuhkan username dan chat-id dari akun telegram anda,') }}</p>
            <p>{{__('2 hal itu digunakan untuk membuat notifikasi pengingat iuran kas PH melalui aplikasi chat Telegram,') }}</p>
            <p>{{__('Untuk kelancaran proses verifikasi dan penyimpanan data transaksi iuran kas PH dan transaksi pembayaran iuran kas PH,') }}</p>
            <p>{{__('Anda harus menyertakan 2 hal tersebut dengan meng-klik tombol "Klik untuk terhubung dengan BOT Bendahara" dibawah ini, Terima Kasih...') }}</p>
            <a href="{{ url('deep-linking') }}" class="btn btn-primary text-center">{{__('Klik untuk terhubung dengan BOT Bendahara') }}</a>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>