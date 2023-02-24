<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <div class="mgbt row">
                    <div class="col-md-6">
                        <h3 class="card-content-title">In tem sản phẩm</h3>
                    </div>
                </div>
                <div class="row mgt15">
                    <div class="col-6">
                        <label for="productName" class="fz13">Tên sản phẩm</label>
                        <input type="text" name="productName" class="form-control productName" autocomplete="off"
                            id="productName" placeholder="Tên sản phẩm" value="">
                        <span class="error_text productNameErr"></span>
                    </div>
                    <div class="col-6">
                        <label for="areaProduct" class="fz13">Nơi sản suất</label>
                        <input type="text" name="areaProduct" class="form-control areaProduct" autocomplete="off"
                            id="areaProduct" placeholder="Nơi sản suất" value="">
                        <span class="error_text areaProductErr"></span>
                    </div>
                </div>

                <div class="row mgt15">
                    <div class="col-3">
                        <label for="viTri" class="fz13">Vị trí luống</label>
                        <input type="text" name="viTri" class="form-control viTri" autocomplete="off" id="viTri"
                            placeholder="Vị trí luống" value="">
                        <span class="error_text viTriErr"></span>
                    </div>
                    <div class="col-3">
                        <label for="soLo" class="fz13">Số lô</label>
                        <input type="text" name="soLo" class="form-control soLo" autocomplete="off" id="soLo"
                            placeholder="Số lô" value="">
                        <span class="error_text soLoErr"></span>
                    </div>
                    
                    <div class="col-6">
                        <label for="ndg" class="fz13">Ngày đóng gói</label>
                        <input type="text" name="ndg" class="form-control ndg datepicker" autocomplete="off" id="ndg"
                            placeholder="Ngày đóng gói" value="">
                        <!-- <input type="text" name="started" class="form-control started datepicker" id="started" placeholder="Ngày bắt đầu" value="" autocomplete="off"> -->
                        <span class="error_text ndgErr"></span>
                    </div>
                </div>
                <div class="row mgt15">
                    <div class="col-6">
                        <label for="ndg" class="fz13">Ngày gieo trồng</label>
                        <input type="text" name="ngt" class="form-control ngt datepicker" autocomplete="off" id="ngt"
                            placeholder="Ngày gieo trồng" value="">
                        <!-- <input type="text" name="started" class="form-control started datepicker" id="started" placeholder="Ngày bắt đầu" value="" autocomplete="off"> -->
                        <span class="error_text ndgErr"></span>
                    </div>
                    <div class="col-6">
                        <label for="nth" class="fz13">Ngày thu hoạch</label>
                        <input type="text" name="nth" class="form-control nth datepicker" autocomplete="off" id="nth"
                            placeholder="Ngày thu hoạch" value="">
                        <span class="error_text hsdErr"></span>
                    </div>
                </div>

                <div class="row mgt15">
                <div class="col-6">
                        <label for="baoQuan" class="fz13">Bảo quản </label>
                        <input type="text" name="baoQuan" class="form-control baoQuan" autocomplete="off" id="baoQuan"
                            placeholder="Bảo quản" value="">
                        <span class="error_text baoQuanErr"></span>
                    </div>
                    <div class="col-6">
                        <label for="bqcd" class="fz13">Hướng dẫn sử dụng</label>
                        <input type="text" name="bqcd" class="form-control bqcd" autocomplete="off" id="bqcd"
                            placeholder="Hướng dẫn sử dụng" value="">
                        <span class="error_text bqcdErr"></span>
                    </div>
                </div>

                <div class="row mgt15">
                    <div class="col-6">
                        <label for="weight" class="fz13">Khối lượng</label>
                        <input type="text" name="weight" class="form-control weight weightProduct" autocomplete="off" id="weight"
                            placeholder="Khối lượng" value="">
                        <span class="error_text weightProductErr"></span>
                    </div>
                    <div class="col-6">
                        <label for="unit" class="fz13">Đơn vị</label>
                        <select name="unit" id="unit" class="form-control chosen-select unit">
                            <option value="0">Gram</option>
                            <option value="1">Kg</option>
                        </select>
                        <span class="error_text unitErr"></span>
                    </div>
                </div>

                <div class="row mgt15">
                    <div class="col-6">
                        <label for="price" class="fz13">Giá/kg</label>
                        <input type="text" name="price" class="form-control price priceProduct" autocomplete="off" id="price"
                            placeholder="Giá" value="">
                        <span class="error_text priceProductErr"></span>
                    </div>
                    <div class="col-6">
                        <label for="thanhTien" class="fz13">Thành tiền</label>
                        <input type="text" name="thanhTien" class="form-control thanhTien" autocomplete="off"
                            id="thanhTien" placeholder="Thành tiền" value="">
                        <span class="error_text thanhTienErr"></span>
                    </div>
                </div>
                <button type="button" style="float: right;" onclick="barcodeProduct()"
                    class="btn btn-default btn-primary " name="transfer" value="1">In tem</button>
            </div>
        </div>
    </div>
</div>
</div>
<div id="theModalPrint" class="modal fade text-center" style="page-break-after: always;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div id="printTable">

            </div>
        </div>
    </div>
</div>