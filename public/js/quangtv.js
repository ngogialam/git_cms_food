$(document).ready(function () {
  

  $(".checkAll").change(function () {
    if (this.checked) {
      $(".checkSingle").each(function () {
        this.checked = true;
      });
      $(".checkAll").each(function () {
        this.checked = true;
      });
    } else {
      $(".checkSingle").each(function () {
        this.checked = false;
      });
      $(".checkAll").each(function () {
        this.checked = false;
      });
    }
  });

  $(".checkSingle").click(function () {
    if ($(this).is(":checked")) {
      var isAllChecked = 0;

      $(".checkSingle").each(function () {
        if (!this.checked) isAllChecked = 1;
      });

      if (isAllChecked == 0) {
        $(".checkAll").prop("checked", true);
      }
    } else {
      $(".checkAll").prop("checked", false);
    }
  });

  $(".modal-body").on("change", ".productPlus", function () {
    var productId = $(this).val();
    var key = $(this).attr("key");
    $.ajax({
      url: "/khuyen-mai/lay-quy-cach",
      type: "post",
      dataType: "json",
      data: {
        productId: productId,
      },
      success: function (res) {
        if (res.success) {
          $(".productPriceKey-" + key).html(res.data);
          $(".productPriceKey-" + key).trigger("chosen:updated");
        } else {
        }
      },
      error: function () {},
    });
  });

  $(".addProductPlus").click(function () {
    var total = $(".productPlusItem").length;
    $.ajax({
      url: "/khuyen-mai/them-san-pham-tang-kem",
      type: "post",
      dataType: "json",
      data: {
        total: total,
      },
      success: function (res) {
        if (res.success) {
          $(".addProductPlus").attr("count", total + 1);
          $(".productPlusItem:last").after(res.data);
          $(".productPlus").chosen();
          $(".productPrice").chosen();
        } else {
        }
      },
      error: function () {},
    });
  });
  $(".modal-body").on("click", ".removeProductPlus", function () {
    var total = $(".productPlusItem").length;
    if (total > 1) {
      $(this).parent().parent().remove();
    } else {
      $(".productPlus").val("");
      $(".productPlus").trigger("chosen:updated");
      $(".pricePlus").val("0");
    }
  });
});

function savePromotion() {
  let promotion = new Array();
  promotion["productId"] = $(".products").val();
  promotion["namePromotion"] = $(".namePromotion").val();
  promotion["measure"] = $(".measure").val();
  promotion["limitApply"] = $(".limitApply").val();
  promotion["quantityMax"] = $(".quantityMax").val();
  promotion["started"] = $(".started").val();
  promotion["stoped"] = $(".stoped").val();
  promotion["status"] = $(".status").val();
  promotion["condition"] = $(".condition").val();

  var count = $(".addProductPlus").attr("count");
  let i = 0;
  let arrPlus = new Array();
  var error = 0;
  do {
    if ($(".productPlusKey-" + i).val() && $(".productPriceKey-" + i).val()) {
      let item = new Array();
      item["productPlus"] = $(".productPlusKey-" + i).val();
      item["productPrice"] = $(".productPriceKey-" + i).val();
      // item['pricePlus']       = $('.pricePlusKey-'+i).val();
      item["quantity"] = $(".quantityKey-" + i).val();
      arrPlus[i] = Object.assign({}, item);
    } else {
      error = 1;
      if ($(".productPlusKey-" + i).val() == "") {
        $(".errProductPlus-" + i).html("Sản phẩm tặng kèm không được để trống");
      }
      if (
        $(".productPriceKey-" + i).val() == "" ||
        $(".productPriceKey-" + i).val() == null
      ) {
        $(".errProductPrice-" + i).html(
          "Quy cách đóng gói không được để trống"
        );
      }
      if (
        $(".quantityKey-" + i).val() == "" ||
        $(".quantityKey-" + i).val() == null
      ) {
        $(".errQuantity-" + i).html("Số lượng không được để trống");
      }
      // if($('.pricePlusKey-'+i).val() == '' || $('.pricePlusKey-'+i).val() == null){
      //     $('.errPricePlus-'+i).html('Giá không được để trống');
      // }
    }
    i = i + 1;
  } while (i < count);
  promotion["arrPlus"] = Object.assign({}, arrPlus);
  // console.log(Object.assign({}, promotion));
  if (error == 0) {
    $.ajax({
      url: "/khuyen-mai/tao-khuyen-mai",
      type: "post",
      dataType: "json",
      data: {
        promotion: Object.assign({}, promotion),
      },
      success: function (res) {
        if (res.success) {
          location.reload();
        } else {
          $(".errProducts").html(res.data.productId);
          $(".errNamePromotion").html(res.data.namePromotion);
          $(".errCondition").html(res.data.condition);
          $(".errStarted").html(res.data.started);
          $(".errStoped").html(res.data.stoped);
        }
      },
      error: function () {},
    });
  }
}

function addCategory() {
  $("#addCategory").modal("show");
  $(".modal-title").html("Thêm danh mục");
  $(".saveCate").html("Thêm danh mục");
  $(".saveCate").attr("onclick", "saveCategory()");
}

function addMenus() {
  $("#addMenus").modal("show");
  $(".modal-title").html("Thêm menus");
  $(".saveMenus").html("Thêm menus");
  $(".saveMenus").attr("onclick", "saveMenus()");
}

function addBanners() {
  $("#addBanners").modal("show");
  $(".modal-title").html("Thêm banner");
  $(".saveBanners").html("Thêm banner");
  $(".saveBanners").attr("onclick", "saveBanners()");
}

function addPromotion() {
  $("#addPromotion").modal("show");
  $(".modal-title").html("Thêm khuyến mãi");
  $(".savePromotion").html("Thêm khuyến mãi");
  $(".savePromotion").attr("onclick", "savePromotion()");
}

function saveCategory() {
  var parentCate = $(".parentCate").val();
  var nameCate = $(".nameCate").val();
  var imgThumbnail = $(".imgThumbnail").val();
  var positionCate = $(".positionCate").val();
  var popularFlag = $(".popularFlag").val();
  var productFlag = $(".productFlag").val();
  var statusCate = $(".status").val();

  $.ajax({
    url: "/danh-muc/tao-danh-muc",
    type: "post",
    dataType: "json",
    data: {
      parentCate: parentCate,
      nameCate: nameCate,
      imgThumbnail: imgThumbnail,
      positionCate: positionCate,
      popularFlag: popularFlag,
      productFlag: productFlag,
      status: statusCate,
    },
    success: function (res) {
      if (res.success) {
        location.reload();
      } else {
        $(".errNameCate").html(res.data.nameCate);
        $(".errPositionCate").html(res.data.positionCate);
      }
    },
    error: function () {},
  });
}

function saveMenus() {
  var parentMenus = $(".parentMenus").val();
  var parentCate = $(".parentCate").val();
  var nameMenus = $(".nameMenus").val();
  var linkMenus = $(".linkMenus").val();
  var imgThumbnail = $(".imgThumbnail").val();
  var positionMenus = $(".positionMenus").val();
  var statusMenus = $(".status").val();

  $.ajax({
    url: "/menus/tao-menus",
    type: "post",
    dataType: "json",
    data: {
      parentMenus: parentMenus,
      parentCate: parentCate,
      nameMenus: nameMenus,
      linkMenus: linkMenus,
      imgThumbnail: imgThumbnail,
      positionMenus: positionMenus,
      status: statusMenus,
    },
    success: function (res) {
      if (res.success) {
        location.reload();
      } else {
        // console.log(res.data.nameCate);
        $(".errNameMenus").html(res.data.nameMenus);
        $(".errLinkMenus").html(res.data.linkMenus);
      }
    },
    error: function () {},
  });
}

function saveBanners() {
  var parentCate = $(".parentCate").val();
  var nameBanners = $(".nameBanners").val();
  var linkBanners = $(".linkBanners").val();
  var imgThumbnail = $(".imgThumbnail").val();
  var statusBanners = $(".status").val();
  var contentBanners = $(".contentBanners").val();

  $.ajax({
    url: "/banners/tao-banners",
    type: "post",
    dataType: "json",
    data: {
      parentCate: parentCate,
      nameBanners: nameBanners,
      linkBanners: linkBanners,
      imgThumbnail: imgThumbnail,
      status: statusBanners,
      contentBanners: contentBanners,
    },
    success: function (res) {
      if (res.success) {
        location.reload();
      } else {
        // console.log(res.data.nameCate);
        $(".errNameBanners").html(res.data.nameBanners);
        $(".errLinkBanners").html(res.data.linkBanners);
      }
    },
    error: function () {},
  });
}

function getRow(id, url_img) {
  $("#addCategory").modal("show");
  $(".saveCate").removeAttr("disabled");
  $.ajax({
    url: "/danh-muc/sua-danh-muc",
    type: "post",
    dataType: "json",
    data: {
      id: id,
      getData: 1,
    },
    success: function (res) {
      if (res.success) {
        // console.log(res.data.nameCate);
        $(".modal-title").html("Sửa danh mục");
        $(".parentCate").html(res.dataCate);
        $(".parentCate").trigger("chosen:updated");
        $("#nameCate").val(res.data.nameCate);
        $(".imgThumbnail").val(res.data.banner);
        if (res.data.banner) {
          $("#newsThumbnailImg").attr("src", url_img + res.data.banner);
          $("#newsThumbnailImg").width("150");
        } else {
          $("#newsThumbnailImg").attr(
            "src",
            "/public/images_kho/btn-add-img.svg"
          );
          $("#newsThumbnailImg").width("70");
        }
        $("#positionCate").val(res.data.position);
        if (res.data.popularFlag == 1) {
          $(".popularFlagYes").attr("selected", "selected");
        } else {
          $(".popularFlagYes").removeAttr("selected", "selected");
        }
        $(".popularFlag").trigger("chosen:updated");
        if (res.data.productFlag == 1) {
          $(".productFlagYes").attr("selected", "selected");
        } else {
          $(".productFlagYes").removeAttr("selected", "selected");
        }
        $(".productFlag").trigger("chosen:updated");
        if (res.data.statusCate == 1) {
          $(".statusYes").attr("selected", "selected");
        } else {
          $(".statusYes").removeAttr("selected", "selected");
        }
        $(".status").trigger("chosen:updated");
        $(".saveCate").html("Sửa danh mục");
        $(".saveCate").attr("onclick", "editCate(" + res.data.id + ")");
      } else {
        $("#addCategory").modal("hide");
      }
    },
    error: function () {},
  });
}

function getRowMenus(id, url_img) {
  $("#addMenus").modal("show");
  $(".btnAddMenu").removeAttr("disabled");
  $.ajax({
    url: "/menus/sua-menus",
    type: "post",
    dataType: "json",
    data: {
      id: id,
      getData: 1,
    },
    success: function (res) {
      if (res.success) {
        // console.log(res.data.nameCate);
        $(".modal-title").html("Sửa menus");
        $(".parentCate").html(res.dataCate);
        $(".parentCate").trigger("chosen:updated");
        $(".parentMenus").html(res.dataMenus);
        $(".parentMenus").trigger("chosen:updated");
        $("#nameMenus").val(res.data.nameMenus);
        $("#linkMenus").val(res.data.link);
        $(".imgThumbnail").val(res.data.banner);
        if (res.data.banner) {
          $("#newsThumbnailImg").attr("src", url_img + res.data.banner);
          $("#newsThumbnailImg").width("150");
        } else {
          $("#newsThumbnailImg").attr(
            "src",
            "/public/images_kho/btn-add-img.svg"
          );
          $("#newsThumbnailImg").width("70");
        }
        $("#positionMenus").val(res.data.position);
        if (res.data.statusMenus == 1) {
          $(".statusYes").attr("selected", "selected");
        } else {
          $(".statusYes").removeAttr("selected", "selected");
        }
        $(".status").trigger("chosen:updated");
        $(".saveMenus").html("Sửa menus");
        $(".saveMenus").attr("onclick", "editMenus(" + res.data.id + ")");
      } else {
        $("#addMenus").modal("hide");
      }
    },
    error: function () {},
  });
}

function getRowBanners(id, url_img) {
  $("#addBanners").modal("show");
  $(".saveBanners").removeAttr("disabled");
  $.ajax({
    url: "/banners/sua-banners",
    type: "post",
    dataType: "json",
    data: {
      id: id,
      getData: 1,
    },
    success: function (res) {
      if (res.success) {
        $(".modal-title").html("Sửa banners");
        $(".parentCate").html(res.dataCate);
        $(".parentCate").trigger("chosen:updated");
        $("#nameBanners").val(res.data.nameBanners);
        $("#contentBanners").html(res.data.contentBanners);
        $("#linkBanners").val(res.data.link);
        $(".imgThumbnail").val(res.data.image);
        if (res.data.image) {
          $("#newsThumbnailImg").attr("src", url_img + res.data.image);
          $("#newsThumbnailImg").width("150");
        } else {
          $("#newsThumbnailImg").attr(
            "src",
            "/public/images_kho/btn-add-img.svg"
          );
          $("#newsThumbnailImg").width("70");
        }
        if (res.data.statusBanners == 1) {
          $(".statusYes").attr("selected", "selected");
        } else {
          $(".statusYes").removeAttr("selected", "selected");
        }
        $(".status").trigger("chosen:updated");
        $(".saveBanners").html("Sửa banners");
        $(".saveBanners").attr("onclick", "editBanners(" + res.data.id + ")");
      } else {
        $("#addBanners").modal("hide");
      }
    },
    error: function () {},
  });
}

function editCate(id) {
  var parentCate = $(".parentCate").val();
  var nameCate = $(".nameCate").val();
  var imgThumbnail = $(".imgThumbnail").val();
  var positionCate = $(".positionCate").val();
  var popularFlag = $(".popularFlag").val();
  var productFlag = $(".productFlag").val();
  var statusCate = $(".status").val();

  $.ajax({
    url: "/danh-muc/sua-danh-muc",
    type: "post",
    dataType: "json",
    data: {
      id: id,
      parentCate: parentCate,
      nameCate: nameCate,
      imgThumbnail: imgThumbnail,
      positionCate: positionCate,
      popularFlag: popularFlag,
      productFlag: productFlag,
      status: statusCate,
      getData: 0,
    },
    success: function (res) {
      if (res.success) {
        location.reload();
      } else {
        // console.log(res.data.nameCate);
        $(".errNameCate").html(res.data.nameCate);
      }
    },
    error: function () {},
  });
}

function editMenus(id) {
  var parentMenus = $(".parentMenus").val();
  var parentCate = $(".parentCate").val();
  var nameMenus = $(".nameMenus").val();
  var linkMenus = $(".linkMenus").val();
  var imgThumbnail = $(".imgThumbnail").val();
  var positionMenus = $(".positionMenus").val();
  var statusMenus = $(".status").val();

  $.ajax({
    url: "/menus/sua-menus",
    type: "post",
    dataType: "json",
    data: {
      id: id,
      parentMenus: parentMenus,
      parentCate: parentCate,
      nameMenus: nameMenus,
      linkMenus: linkMenus,
      imgThumbnail: imgThumbnail,
      positionMenus: positionMenus,
      status: statusMenus,
      getData: 0,
    },
    success: function (res) {
      if (res.success) {
        location.reload();
      } else {
        // console.log(res.data.nameCate);
        $(".errNameMenus").html(res.data.nameMenus);
        $(".errLinkMenus").html(res.data.linkMenus);
      }
    },
    error: function () {},
  });
}

function editBanners(id) {
  var parentCate = $(".parentCate").val();
  var nameBanners = $(".nameBanners").val();
  var linkBanners = $(".linkBanners").val();
  var imgThumbnail = $(".imgThumbnail").val();
  var contentBanners = $(".contentBanners").val();
  var statusBanners = $(".status").val();
  $.ajax({
    url: "/banners/sua-banners",
    type: "post",
    dataType: "json",
    data: {
      id: id,
      parentCate: parentCate,
      nameBanners: nameBanners,
      linkBanners: linkBanners,
      imgThumbnail: imgThumbnail,
      contentBanners: contentBanners,
      status: statusBanners,
      getData: 0,
    },
    success: function (res) {
      if (res.success) {
        location.reload();
      } else {
        // console.log(res.data.nameCate);
        $(".errNameBanners").html(res.data.nameBanners);
      }
    },
    error: function () {},
  });
}

function disableRow(id) {
  $("#confirmDeleteRow").modal("show");
  $(".confirmBody").html("<p>Bạn có chắc xoá danh mục?</p>");
  $(".btnDeleteRow").attr("onclick", 'confirmDisableRow("' + id + '", 0)');
  $(".btnDeleteRow").html("Xoá");
  $(".btnDeleteRow").removeClass("btn-success");
  $(".btnDeleteRow").addClass("btn-danger");
}

function disableRowMenus(id) {
  $("#confirmDeleteRow").modal("show");
  $(".confirmBody").html("<p>Bạn có chắc xoá menus?</p>");
  $(".btnDeleteRow").attr("onclick", 'confirmDisableRowMenus("' + id + '", 0)');
  $(".btnDeleteRow").html("Xoá");
  $(".btnDeleteRow").removeClass("btn-success");
  $(".btnDeleteRow").addClass("btn-danger");
}

function disableRowBanners(id) {
  $("#confirmDeleteRow").modal("show");
  $(".confirmBody").html("<p>Bạn có chắc xoá banners?</p>");
  $(".btnDeleteRow").attr(
    "onclick",
    'confirmDisableRowBanners("' + id + '", 0)'
  );
  $(".btnDeleteRow").html("Xoá");
  $(".btnDeleteRow").removeClass("btn-success");
  $(".btnDeleteRow").addClass("btn-danger");
}

function disableRowPromotion(id, typeOrder) {
  $("#confirmDeleteRow").modal("show");
  $(".confirmBody").html("<p>Bạn có chắc xoá khuyến mãi?</p>");
  $(".btnDeleteRow").attr(
    "onclick",
    'confirmDisableRowPromotion("' + id + '", 0, ' + typeOrder + ")"
  );
  $(".btnDeleteRow").html("Xoá");
  $(".btnDeleteRow").removeClass("btn-success");
  $(".btnDeleteRow").addClass("btn-danger");
}

function activeRowPromotion(id, typeOrder) {
  $("#confirmDeleteRow").modal("show");
  $(".confirmBody").html("<p>Bạn có chắc muốn kích hoạt khuyến mãi?</p>");
  $(".btnDeleteRow").attr(
    "onclick",
    'confirmDisableRowPromotion("' + id + '", 1, ' + typeOrder + ")"
  );
  $(".btnDeleteRow").html("Kích hoạt");
  $(".btnDeleteRow").removeClass("btn-danger");
  $(".btnDeleteRow").addClass("btn-success");
}

function disableRowAll() {
  var ids = "";
  var totalItem = $(".checkSingle:checked").length;
  $(".checkSingle:checked").each(function () {
    ids += $(this).val() + ",";
  });
  if (totalItem <= 0) {
    setTimeout(function () {
      alert("Bạn chưa chọn danh mục nào để xoá");
    }, 400);
  } else {
    ids = ids.slice(0, -1);
    $("#confirmDeleteRow").modal("show");
    $(".confirmBody").html("<p>Bạn có chắc xoá các danh mục đã chọn?</p>");
    $(".btnDeleteRow").attr("onclick", 'confirmDisableRow("' + ids + '", 0)');
    $(".btnDeleteRow").html("Xoá");
    $(".btnDeleteRow").removeClass("btn-success");
    $(".btnDeleteRow").addClass("btn-danger");
  }
}

function disableRowAllMenus() {
  var ids = "";
  var totalItem = $(".checkSingle:checked").length;
  $(".checkSingle:checked").each(function () {
    ids += $(this).val() + ",";
  });
  if (totalItem <= 0) {
    setTimeout(function () {
      alert("Bạn chưa chọn menus nào để xoá");
    }, 400);
  } else {
    ids = ids.slice(0, -1);
    $("#confirmDeleteRow").modal("show");
    $(".confirmBody").html("<p>Bạn có chắc xoá các menus đã chọn?</p>");
    $(".btnDeleteRow").attr(
      "onclick",
      'confirmDisableRowMenus("' + ids + '", 0)'
    );
    $(".btnDeleteRow").html("Xoá");
    $(".btnDeleteRow").removeClass("btn-success");
    $(".btnDeleteRow").addClass("btn-danger");
  }
}

function disableRowAllBanners() {
  var ids = "";
  var totalItem = $(".checkSingle:checked").length;
  $(".checkSingle:checked").each(function () {
    ids += $(this).val() + ",";
  });
  if (totalItem <= 0) {
    setTimeout(function () {
      alert("Bạn chưa chọn banners nào để xoá");
    }, 400);
  } else {
    ids = ids.slice(0, -1);
    $("#confirmDeleteRow").modal("show");
    $(".confirmBody").html("<p>Bạn có chắc xoá các banners đã chọn?</p>");
    $(".btnDeleteRow").attr(
      "onclick",
      'confirmDisableRowBanners("' + ids + '", 0)'
    );
    $(".btnDeleteRow").html("Xoá");
    $(".btnDeleteRow").removeClass("btn-success");
    $(".btnDeleteRow").addClass("btn-danger");
  }
}

function disableRowAllPromotion(typeOrder) {
  var ids = "";
  var totalItem = $(".checkSingle:checked").length;
  $(".checkSingle:checked").each(function () {
    ids += $(this).val() + ",";
  });
  if (totalItem <= 0) {
    setTimeout(function () {
      alert("Bạn chưa chọn khuyến mãi nào để xoá");
    }, 400);
  } else {
    ids = ids.slice(0, -1);
    $("#confirmDeleteRow").modal("show");
    $(".confirmBody").html("<p>Bạn có chắc xoá các khuyến mãi đã chọn?</p>");
    $(".btnDeleteRow").attr(
      "onclick",
      'confirmDisableRowPromotion("' + ids + '", 0, ' + typeOrder + ")"
    );
    $(".btnDeleteRow").html("Xoá");
    $(".btnDeleteRow").removeClass("btn-success");
    $(".btnDeleteRow").addClass("btn-danger");
  }
}

function activeRowAll() {
  var ids = "";
  var totalItem = $(".checkSingle:checked").length;
  $(".checkSingle:checked").each(function () {
    ids += $(this).val() + ",";
  });
  if (totalItem <= 0) {
    setTimeout(function () {
      alert("Bạn chưa chọn danh mục nào để kích hoạt");
    }, 400);
  } else {
    ids = ids.slice(0, -1);
    $("#confirmDeleteRow").modal("show");
    $(".confirmBody").html(
      "<p>Bạn có muốn kích hoạt các danh mục đã chọn?</p>"
    );
    $(".btnDeleteRow").attr("onclick", 'confirmDisableRow("' + ids + '", 1)');
    $(".btnDeleteRow").html("Kích hoạt");
    $(".btnDeleteRow").removeClass("btn-danger");
    $(".btnDeleteRow").addClass("btn-success");
  }
}

function activeRowAllMenus() {
  var ids = "";
  var totalItem = $(".checkSingle:checked").length;
  $(".checkSingle:checked").each(function () {
    ids += $(this).val() + ",";
  });
  if (totalItem <= 0) {
    setTimeout(function () {
      alert("Bạn chưa chọn menus nào để kích hoạt");
    }, 400);
  } else {
    ids = ids.slice(0, -1);
    $("#confirmDeleteRow").modal("show");
    $(".confirmBody").html("<p>Bạn có muốn kích hoạt các menus đã chọn?</p>");
    $(".btnDeleteRow").attr(
      "onclick",
      'confirmDisableRowMenus("' + ids + '", 1)'
    );
    $(".btnDeleteRow").html("Kích hoạt");
    $(".btnDeleteRow").removeClass("btn-danger");
    $(".btnDeleteRow").addClass("btn-success");
  }
}

function activeRowAllBanners() {
  var ids = "";
  var totalItem = $(".checkSingle:checked").length;
  $(".checkSingle:checked").each(function () {
    ids += $(this).val() + ",";
  });
  if (totalItem <= 0) {
    setTimeout(function () {
      alert("Bạn chưa chọn banners nào để kích hoạt");
    }, 400);
  } else {
    ids = ids.slice(0, -1);
    $("#confirmDeleteRow").modal("show");
    $(".confirmBody").html("<p>Bạn có muốn kích hoạt các banners đã chọn?</p>");
    $(".btnDeleteRow").attr(
      "onclick",
      'confirmDisableRowBanners("' + ids + '", 1)'
    );
    $(".btnDeleteRow").html("Kích hoạt");
    $(".btnDeleteRow").removeClass("btn-danger");
    $(".btnDeleteRow").addClass("btn-success");
  }
}

function activeRowAllPromotion(typeOrder) {
  var ids = "";
  var totalItem = $(".checkSingle:checked").length;
  $(".checkSingle:checked").each(function () {
    ids += $(this).val() + ",";
  });
  if (totalItem <= 0) {
    setTimeout(function () {
      alert("Bạn chưa chọn khuyến mãi nào để kích hoạt");
    }, 400);
  } else {
    ids = ids.slice(0, -1);
    $("#confirmDeleteRow").modal("show");
    $(".confirmBody").html(
      "<p>Bạn có muốn kích hoạt các khuyến mãi đã chọn?</p>"
    );
    $(".btnDeleteRow").attr(
      "onclick",
      'confirmDisableRowPromotion("' + ids + '", 1, ' + typeOrder + ")"
    );
    $(".btnDeleteRow").html("Kích hoạt");
    $(".btnDeleteRow").removeClass("btn-danger");
    $(".btnDeleteRow").addClass("btn-success");
  }
}

function confirmDisableRow(id, status) {
  $.ajax({
    url: "/danh-muc/xoa-danh-muc",
    type: "post",
    dataType: "json",
    data: {
      id: id,
      status: status,
    },
    success: function (res) {
      location.reload();
    },
    error: function () {},
  });
}

function confirmDisableRowMenus(id, status) {
  $.ajax({
    url: "/menus/xoa-menus",
    type: "post",
    dataType: "json",
    data: {
      id: id,
      status: status,
    },
    success: function (res) {
      location.reload();
    },
    error: function () {},
  });
}

function confirmDisableRowBanners(id, status) {
  $.ajax({
    url: "/banners/xoa-banners",
    type: "post",
    dataType: "json",
    data: {
      id: id,
      status: status,
    },
    success: function (res) {
      location.reload();
    },
    error: function () {},
  });
}

function confirmDisableRowPromotion(id, status, typeOrder) {
  $.ajax({
    url: "/khuyen-mai/xoa-khuyen-mai",
    type: "post",
    dataType: "json",
    data: {
      id: id,
      status: status,
      typeOrder: typeOrder,
    },
    success: function (res) {
      // console.log(res);
      location.reload();
    },
    error: function () {},
  });
}

//Config date
$(".datePicker").datetimepicker({
  timepicker: false,
  format: "d/m/Y",
});

function validateParcelMaterial() {
  var parcelMaterial = $(".parcelMaterial").val();
  if (parcelMaterial == "" || parcelMaterial <= 0) {
    $(".errParcelMaterial").html("Không được trống");
  } else {
    $(".errParcelMaterial").html("");
  }
}

function validateHarvestTime() {
  var harvestTime = $(".harvestTime").val();
  if (harvestTime == "") {
    $(".errHarvestTime").html("Không được trống");
  } else {
    $(".errHarvestTime").html("");
  }
}

function validateHandingTime() {
  var handingTime = $(".handingTime").val();
  if (handingTime == "") {
    $(".errHandingTime").html("Không được trống");
  } else {
    $(".errHandingTime").html("");
  }
}

function validateExpirationTime() {
  var expirationTime = $(".expirationTime").val();
  if (expirationTime == "") {
    $(".errExpirationTime").html("Không được trống");
  } else {
    $(".errExpirationTime").html("");
  }
}

function importItems() {
  let itemsCode = $(".itemsCode").val();
  var parcelMaterial = $(".parcelMaterial").val();
  var material = $(".material").val();
  var harvestTime = $(".harvestTime").val();
  var handingTime = $(".handingTime").val();
  var expirationTime = $(".expirationTime").val();

  var error = 0;
  if (parcelMaterial == "" || parcelMaterial <= 0) {
    $(".errParcelMaterial").html("Không được trống");
    error = 1;
  }
  if (harvestTime == "") {
    $(".errHarvestTime").html("Không được trống");
    error = 1;
  }
  if (handingTime == "") {
    $(".errHandingTime").html("Không được trống");
    error = 1;
  }
  if (expirationTime == "") {
    $(".errExpirationTime").html("Không được trống");
    error = 1;
  }

  code = itemsCode.substr(2, 5);
  let weight = itemsCode.substr(7, 5);

  if (error == 0 && code > 0 && weight > 0) {
    $.ajax({
      url: "/thanh-pham/tao-thanh-pham",
      type: "post",
      dataType: "json",
      data: {
        code: code,
        weight: weight,
        parcelMaterial: parcelMaterial,
        material: material,
        harvestTime: harvestTime,
        handingTime: handingTime,
        expirationTime: expirationTime,
      },
      success: function (res) {
        console.log(res);
      },
      error: function () {},
    });
  }
}

function addDish() {
  nameDish = $("#nameDish").val().trim();
  statusOnWeb = $("#statusOnWeb").val();
  stock = $("#stock").val().trim();
  originalPrice = $("#originalPrice").val();
  sellingPrice = $("#sellingPrice").val();
  position = $("#position").val();
  imgThumbnail = $("#imgThumbnail").val();
  restaurantId = $("#restaurantId").val();
  sellingPrice = sellingPrice.replace(/\,/g, "");
  originalPrice = originalPrice.replace(/\,/g, "");
  dataContentNews = contentNews.getData();

  let checkDataCallApi = 0;
  if (nameDish == "") {
    $(".errNameDish").html("Vui lòng nhập tên món ăn");
    checkDataCallApi = 1;
  } else {
    $(".errNameDish").html("");
  }
  if (stock == "") {
    $(".errStock").html("Vui lòng nhập số lượng món ăn");
    checkDataCallApi = 1;
  } else {
    $(".errStock").html("");
  }

  if (originalPrice == "") {
    $(".errOriginalPrice").html("Vui lòng nhập giá gốc");
    checkDataCallApi = 1;
  } else {
    $(".errOriginalPrice").html("");
  }

  if (sellingPrice == "" || sellingPrice == 0) {
    $(".errSellingPrice").html("Vui lòng nhập giá bán");
    checkDataCallApi = 1;
  } else {
    $(".errSellingPrice").html("");
  }
  if (restaurantId == 0) {
    $(".errRestaurantId").html("Vui lòng chọn nhà hàng");
    checkDataCallApi = 1;
  } else {
    $(".errRestaurantId").html("");
  }
  
  if(parseInt(originalPrice) < parseInt(sellingPrice) ){
    $(".errSellingPrice").html("Giá bán phải nhỏ hơn hoặc bằng giá gốc");
    checkDataCallApi = 1;
  } else {
    $(".errSellingPrice").html("");
  }

  // if (position == '') {
  //     $('.errPosition').html('Vui lòng nhập số thứ tự')
  //     checkDataCallApi = 1
  // } else {
  //     $('.errPosition').html('')

  // }

  if (stock == "") {
    $(".errStock").html("Vui lòng nhập số lượng món ăn");
    checkDataCallApi = 1;
  } else {
    $(".errStock").html("");
  }

  if (statusOnWeb == -1) {
    $(".errStatusOnWeb").html("Vui lòng chọn trạng thái món ăn");
    checkDataCallApi = 1;
  } else {
    $(".errStatusOnWeb").html("");
  }

  if (dataContentNews == "") {
    $(".errContentDish").html("Vui lòng thêm mô tả món ăn");
    checkDataCallApi = 1;
  } else {
    $(".errContentDish").html("");
  }

  if (imgThumbnail == "") {
    $(".errNewsThumbnailImg").html("Vui lòng thêm ảnh thumb");
    checkDataCallApi = 1;
  } else {
    $(".errNewsThumbnailImg").html("");
  }

  var ek = $(".inputImgBs")
    .map((_, el) => el.value)
    .get();
  if (ek.length === 1) {
    $(".errImagesDish").html("Vui lòng thêm ảnh món ăn");
    checkDataCallApi = 1;
  } else {
    $(".errImagesDish").html("");
  }


  var countCHeck = $(".frontBsRegisImg").attr("count");
  console.log(countCHeck);
  var imgValues = "";
  for (var i = 1; i <= countCHeck; i++) {
    console.log(i);
    imgValues += $(".inputImgValueBs_" + i).val() + "|";
  }
  imgJson = imgValues.slice(0, -1);
  console.log("imgValues", imgValues);

  if (checkDataCallApi == 0) {
    $('#loader').addClass('show');
    $.ajax({
      url: "/mon-an/callApiAddNewDish",
      type: "post",
      dataType: "json",
      data: {
        name: nameDish,
        status: statusOnWeb,
        originalPrice: originalPrice,
        sellingPrice: sellingPrice,
        stock: stock,
        position: position,
        thumbnailImage: imgThumbnail,
        imageDish: imgJson,
        contentDish: dataContentNews,
        isBestSelling: 1,
        isFavorite: 1,
        restaurantId: restaurantId,
      },
      success: function (res) {
        if(res.success){
          location.reload();
      }else{
          console.log(res.status)
          if(res.status == 208){
              $('#loader').removeClass('show');
              $('.errNameDish').html(res.message)
              $('.errNameDish').focus();
          }
      }
      },
      error: function () {
        location.reload();
      },
    });
  }
}

function changeDataInput(classChange) {
  $("." + classChange).html("");
  if (classChange == "errOriginalPrice") {
    let price = parseInt($("#originalPrice").val());
    if (!isNaN(price)) $("#originalPrice").val(price.toLocaleString("en-US"));
  }

  if (classChange == "errSellingPrice") {
    let sellingPrice = parseInt($("#sellingPrice").val());
    console.log(sellingPrice);
    if (!isNaN(sellingPrice))
      $("#sellingPrice").val(sellingPrice.toLocaleString("en-US"));
  }

  if (classChange == "errStock") {
    let stock = parseInt($("#stock").val());
    if (!isNaN(stock)) $("#stock").val(stock.toLocaleString("en-US"));
  }
}

function changeTimeSale() {
  let timeStart = $("#time-start").val();
  let timeEnd = $("#time-end").val();
  let id = $("#selectTime").val();
  console.log(id);
  if (timeStart == "") {
    alert("Vui lòng kiểm tra lại thời gian bắt đầu mở bán");
  } else if (timeEnd == "") {
    alert("Vui lòng kiểm tra lại thời gian đóng bán");
  } else if (
    parseInt(timeEnd.replace(":", "")) - parseInt(timeStart.replace(":", "")) < 0 
  ) {
    alert("Thời gian kết thúc phải lớn hơn thời gian bắt đầu");
  }else if(parseInt(timeEnd.replace(":", "")) - parseInt(timeStart.replace(":", "")) == 0 ){
    alert("Thời gian kết thúc không được bằng thời gian bắt đầu");
  } else if (id == -1 || id == "") {
    alert("Vui lòng chọn nhà hàng để thay đổi");
  } else {
    $("#confirmChangeTimeSale").modal("show");
  }
}

function confirmChangeTimeSale() {
  $("#confirmChangeTimeSale").modal("hide");
  let timeStart = $("#time-start").val();
  let timeEnd = $("#time-end").val();
  let id = $("#selectTime").val();
  // Call api confirm change time sale

  $.ajax({
    url: "/mon-an/changeTimeSale",
    type: "post",
    dataType: "json",
    data: {
      id: id,
      timeStart: timeStart,
      timeEnd: timeEnd,
    },
    success: function (res) {
      alert(res.message);
    },
    error: function () {},
  });
}

function actionSale(action) {
  var ids = [];
  $(".checkSingle:checked").each(function () {
    ids.push({
      id: $(this).val(),
    });
  });
  console.log(ids);
  if (action === "openSale") {
  }

  if (action === "closeSale") {
  }
}

function checkTime() {
  let id = $("#selectTime").val();
  $.ajax({
    url: "/mon-an/checkTimeOpening",
    type: "post",
    dataType: "json",
    data: {
      id: id,
    },
    success: function (res) {
      console.log(res)
      if (res.data.data.length !== 0) {
        $("#time-start").val(res.data.data[0].timeOrderFrom);
        $("#time-end").val(res.data.data[0].timeOrderTo);
      } else {
        $("#time-start").val();
        $("#time-end").val();
      }
    },
    error: function () {},
  });
}
