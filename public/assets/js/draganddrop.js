document.addEventListener("DOMContentLoaded", () => {
  console.log("drag");
  const dropZone = document.getElementById("dropZone");
  const tbDrag = ["dragenter", "dragleave", "dragover", "drop"];
  const fileInfo = document.querySelector(".fileInfo");
  tbDrag.forEach((element) => {
    dropZone.addEventListener(element, (e) => {
      e.preventDefault();
      e.stopPropagation();

      if (element === "drop") {
        let dt = e.dataTransfer;
        let file = dt.files;

        let name = file[0].name;
        let size = file[0].size / 1000 + "ko";
        fileInfo.innerHTML = name + " - " + size;

        console.dir(file);
      }
    });
  });
});
