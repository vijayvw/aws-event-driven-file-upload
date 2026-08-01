document.addEventListener("DOMContentLoaded", () => {
    // -----------------------------
    // Page Fade In
    // -----------------------------
    document.body.style.opacity = "0";

    requestAnimationFrame(() => {
        document.body.style.transition = "opacity .6s ease";
        document.body.style.opacity = "1";
    });

    // -----------------------------
    // Elements
    // -----------------------------
    const form = document.querySelector("form");
    const fileInput = document.querySelector('input[type="file"]');
    const dropArea = document.querySelector(".drop-area");
    const progressFill = document.querySelector(".progress-fill");
    const progressText = document.querySelector(".progress-text");
    const uploadBtn = document.querySelector(".upload-btn");

    // -----------------------------
    // File Info
    // -----------------------------
    const fileInfo = document.createElement("div");
    fileInfo.className = "file-info";
    fileInfo.style.marginTop = "20px";
    fileInfo.style.textAlign = "center";
    fileInfo.style.color = "#b9c5da";

    dropArea.appendChild(fileInfo);

    function updateFileInfo(file) {
        if (!file) {
            fileInfo.innerHTML = "";
            progressFill.style.width = "0%";
            progressText.textContent = "Ready to Upload";
            return;
        }

        const size =
            file.size > 1024 * 1024
                ? (file.size / (1024 * 1024)).toFixed(2) + " MB"
                : (file.size / 1024).toFixed(2) + " KB";

        fileInfo.innerHTML = `
            <strong>${file.name}</strong><br>
            ${size}
        `;

        progressFill.style.width = "0%";
        progressText.textContent = "Ready to Upload";
    }

    // -----------------------------
    // File Picker
    // -----------------------------
    fileInput.addEventListener("change", () => {
        updateFileInfo(fileInput.files[0]);
    });

    // -----------------------------
    // Drag & Drop
    // -----------------------------
    ["dragenter", "dragover"].forEach(event => {
        dropArea.addEventListener(event, e => {
            e.preventDefault();
            dropArea.classList.add("drag-active");
        });
    });

    ["dragleave", "drop"].forEach(event => {
        dropArea.addEventListener(event, e => {
            e.preventDefault();
            dropArea.classList.remove("drag-active");
        });
    });

    dropArea.addEventListener("drop", e => {
        const files = e.dataTransfer.files;

        if (files.length) {
            fileInput.files = files;
            updateFileInfo(files[0]);
        }
    });

    // -----------------------------
    // Upload
    // -----------------------------
    form.addEventListener("submit", function (e) {
        e.preventDefault();

        if (!fileInput.files.length) {
            alert("Please select a file.");
            return;
        }

        uploadBtn.disabled = true;
        uploadBtn.innerHTML = "Uploading...";

        progressFill.style.width = "0%";
        progressText.textContent = "Uploading...";

        const formData = new FormData(form);

        const xhr = new XMLHttpRequest();

        xhr.open("POST", form.action, true);

        xhr.upload.onprogress = function (e) {
            if (e.lengthComputable) {
                const percent = Math.round((e.loaded / e.total) * 100);

                progressFill.style.width = percent + "%";
                progressText.textContent = percent + "% Uploaded";
            }
        };

        xhr.onload = function () {

    uploadBtn.disabled = false;

    try {

        const data = JSON.parse(xhr.responseText);

        if (xhr.status === 200 && data.success) {

            progressFill.style.width = "100%";

            progressText.textContent = "Upload Complete";

            uploadBtn.innerHTML = "✅ Upload Complete";

            uploadBtn.style.background =
                "linear-gradient(135deg,#2BE675,#00C853)";

            showSuccessPopup(data);

        } else {

            showErrorPopup(data.message);

        }

    } catch (err) {

        showErrorPopup("Invalid server response.");

    }

};

        xhr.onerror = function () {

            uploadBtn.disabled = false;

            progressText.textContent = "Upload Failed";

            uploadBtn.innerHTML = "Upload Again";

            showErrorPopup("Network Error");

        };

        xhr.send(formData);
    });

    // -----------------------------
    // Success Popup
    // -----------------------------
  function showSuccessPopup(data) {

    const popup = document.createElement("div");

    popup.className = "upload-success-overlay";

    popup.innerHTML = `

<div class="upload-success-card">

<div class="success-circle">

✅

</div>

<h2>Upload Successful!</h2>

<p class="success-subtitle">

Your file has been uploaded to Amazon S3 successfully.

</p>

<div class="success-info">

<div>

<span>📁 File</span>

<strong>${data.file}</strong>

</div>

<div>

<span>📦 Size</span>

<strong>${data.size}</strong>

</div>

<div>

<span>🪣 Bucket</span>

<strong>${data.bucket}</strong>

</div>

</div>

<div class="success-status">

<p>☁️ Stored in Amazon S3</p>

<p>⚡ Lambda will process this object automatically</p>

<p>📧 SNS notification will be sent</p>

</div>

<div class="success-actions">

<a
href="${data.url}"
target="_blank"
class="btn-secondary">

Open File

</a>

<button
class="btn-primary"
id="upload-again">

Upload Another File

</button>

</div>

</div>

`;

    document.body.appendChild(popup);

    document
        .getElementById("upload-again")
        .addEventListener("click", () => {

            popup.remove();

            form.reset();

            fileInfo.innerHTML = "";

            progressFill.style.width = "0%";

            progressText.textContent = "Ready to Upload";

            uploadBtn.innerHTML = "Upload to Amazon S3";

            uploadBtn.disabled = false;

            uploadBtn.style.background = "";

        });

}

    // -----------------------------
    // Error Popup
    // -----------------------------
    function showErrorPopup(message) {

        const popup = document.createElement("div");

        popup.className = "popup error-popup";

        popup.innerHTML = `
            <div class="popup-card">
                <h2>❌ Upload Failed</h2>
                <p>${message || "Please try again."}</p>
                <button id="error-btn">Try Again</button>
            </div>
        `;

        document.body.appendChild(popup);

        document
            .getElementById("error-btn")
            .addEventListener("click", () => {
                location.reload();
            });
    }
});