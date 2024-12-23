// Dynamic Elements or Interactivity
document.addEventListener("DOMContentLoaded", function () {
    // Example: Toggle visibility for job description
    const jobDetails = document.querySelectorAll(".job-toggle");

    jobDetails.forEach((btn) => {
        btn.addEventListener("click", function () {
            const jobId = this.dataset.jobId;
            const details = document.getElementById(`details-${jobId}`);

            if (details) {
                details.style.display = details.style.display === "none" ? "block" : "none";
            }
        });
    });
});
