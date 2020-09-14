<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header dis-block bg-secondary">
                <h4 class="text-center color-white">{{__('Pemberitahuan') }}</h4>
            </div>
            <div class="modal-body text-center">
            <p>{{__('Admin Tidak Dapat Menambah Reminder') }}</p>
            <p>{{__('Jika Data Iuran Kas PH Belum Ditambahkan,') }}</p>
            <p>{{__('Maka Tambahkan Data Iuran Kas PH') }}</p>
            <p>{{__('Sehingga Reminder Dapat Dibuat, Terima Kasih') }}</p>
            <a href="{{ route('admin-kas-ph.create') }}" class="btn btn-warning text-center">{{__('Buat Iuran Kas PH') }}</a>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>