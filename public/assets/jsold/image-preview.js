var modal = document.getElementById("myModal");
$(document).on("click", ".imagepop", function () {

    var modalImg = document.getElementById("img01");
    modal.style.display = "block";
    modalImg.src = this.src;
    $("#myModal").modal("show");
});
$(document).on("click", ".close", function () {
    modal.style.display = "none";
});