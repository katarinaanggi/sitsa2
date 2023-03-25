<script>
    function jenis(){
        var v = document.getElementById("total_pickup");
        var w = document.getElementById("total_online");
        var x = document.getElementById("jenis");
        var y = document.getElementById("fee");
        if(x.value == "pickup"){
            v.style.display = "inline-block";
            w.style.display = "none";
            y.style.display = "none";
        }
       else{
            v.style.display = "none";
            w.style.display = "inline-block";
            y.style.display = "contents";
        }
    }
</script>
<div class="p-2">
    <select name="jenis" id="jenis" class="form-select" required onchange="jenis()">
        <option value="online" @if(isset($jenis) && $jenis=="online") 
        {{ 'selected="true"' }} @endif>Online</option>
        <option value="pickup" @if(isset($jenis) && $jenis=="pickup") 
        {{ 'selected="true"' }} @endif>Self Pickup</option>
    </select>
    <table class="table table-borderless mt-3 text-right">
        <tr>
            <td>Subtotal</td> 
            <td><b>Rp{{ number_format($total,0, ',' , '.') }}</b></td>
        </tr>
        <tr id="fee">
            <td>Biaya Pengiriman</td> 
            <td><b>Rp{{ number_format($fee,0, ',' , '.') }}</b></td>
        </tr>
        <tr id="total">
            <td>Total</td>
            <td id="total_pickup" style="display: none"><b>Rp{{ number_format($total,0, ',' , '.') }}</b></td>
            <td id="total_online"><b>Rp{{ number_format($total_online,0, ',' , '.') }}</b></td>
        </tr>
    </table>
    <input type="hidden" id="tp" name="tp" value="{{ $total }}">
    <input type="hidden" id="to" name="to" value="{{ $total_online }}">
    <button class="btn btn-primary btn-block mt-5" onclick="order({{ auth()->user()->id }})">Buat Pemesanan</button>
</div>