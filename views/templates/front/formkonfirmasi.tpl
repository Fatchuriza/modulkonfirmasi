<style>
    #pembayaran-form label.error{
        font:12px Arial, Helvetica, Tahoma,sans-serif;
        color:#ED7476;
        margin-left:5px;
        display: inline-block;
    }
    #pembayaran-form input.error{
        border:1px solid #ED7476;
    }
    #pembayaran-form label.valid{
        margin-left:5px;
        display: inline-block;
    }
    #pembayaran-form input.valid{
        border:1px solid #33cc00;
    }
</style>
<script>
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    $(function() {
        $( "#tanggal_transfer" ).datepicker({
            dateFormat: "yy-mm-dd"
        });
        $('#pembayaran-form').validate({
            //ignore: null,
            ignore: 'input[type="hidden"]',
            rules: {
                no_order: {
                    required: true,
                },
                nama_bank:{
                    required:true,
                },
                nama_pengirim:{
                    required:true,
                },
                tanggal_transfer:{
                    required:true,
                },
                jumlah_dana:{
                    required:true,
                }
            },
            messages: {
                no_order: {
                    required: "Tolong isi Nomor Order",
                },
                nama_bank: {
                    required: "Tolong isi Nama Bank",
                },
                nama_pengirim: {
                    required: "Tolong isi Nama Pengirim",
                },
                tanggal_transfer: {
                    required: "Tolong isi Tanggal Transfer",
                },
                jumlah_dana: {
                    required: "Tolong isi Jumlah Dana",
                }
            }
        });
    });
</script>
<div class="box box-small clearfix">
    <p class="dark">
        <strong>{l s='Konfirmasi Pembayaran dengan Order Reference %s - dipesan pada tanggal' sprintf=$order->getUniqReference()} {dateFormat date=$order->date_add full=0}</strong>
    </p>
</div>
<div class="box box-small clearfix">
    <div class="rte col-xs-12 col-sm-6">
        <form action="{$link->getModuleLink('modulkonfirmasi', 'DetailKonfirmasi')}" method="POST" id="pembayaran-form">
            <div class="form-group">
                <label for="no_order" class="">Nomor Order</label>
                <input type="text" id="no_order" class="form-control" name="no_order" value='{l s='%s' sprintf=$order->getUniqReference()}' readonly/>
            </div>
            <div class="form-group">
                <label for="nama_bank" class="required">Nama Bank</label>
                <input type="text" name="nama_bank" id="nama_bank" class="form-control" placeholder="Masukan nama bank"/>
            </div>
            <div class="form-group">
                <label for="nama_pengirim" class="required">Nama Pengirim</label>
                <input type="text" name="nama_pengirim" id="nama_pengirim" class="form-control"  placeholder="Masukan nama pengirim"/>
            </div>
            <div class="form-group">
                <label for="tanggal_transfer" class="required">Tanggal Transfer</label>
                <input type="text" name="tanggal_transfer" id="tanggal_transfer" type="date" class="form-control"  placeholder="Masukkan tanggal transfer, yyyy-mm-dd"/>
            </div>
            <div class="form-group">
                <label for="jumlah_dana" class="required">Jumlah Dana Transfer</label>
                <input type="text" name="jumlah_dana" id="jumlah_dana" class="form-control" onkeypress="return isNumberKey(event)" placeholder="Masukan jumlah dana. Contoh: 100000"/>
            </div>
            <div class="submit">
                <button type="submit" name="mymod_pc_submit_konfirmasi" class="button btn btn-default button-medium">
                    <span>Send<i class="icon-chevron-right right"></i></span>
                </button>
            </div>
        </form>
    </div>
</div>

