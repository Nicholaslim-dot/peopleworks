  function createForm(wo, records, index) {
    const form = document.createElement("form");
    form.classList.add("caseForm");
    form.id = `caseForm-${index}`;

    const r = records[0];

    form.innerHTML = `
      <!-- Case Information -->
      <div class="form-section">
        <h5>Case Information</h5>
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="caseId-${index}">Case ID :</label>
            <input type="text" class="form-control" id="caseId-${index}" name="caseId"
                   value="${r.case_id || ''}" readonly>
          </div>
        </div>
      </div>

      <!-- Case Details -->
      <div class="form-section">
        <h5>Case Details</h5>
        <div class="form-row">
          <div class="form-group col-md-3">
            <label for="wo-${index}">WO :</label>
            <input type="text" class="form-control" id="wo-${index}" name="wo" value="${wo}" readonly>
          </div>
          <div class="form-group col-md-3">
            <label for="ce-${index}">CE :</label>
            <input type="text" class="form-control" id="ce-${index}" name="ce" value="${r.engineer || ''}">
          </div>
          <div class="form-group col-md-3">
            <label for="learnerId-${index}">Learner ID :</label>
            <input type="text" class="form-control" id="learnerId-${index}" name="learnerId" value="${r.learner_id || ''}">
          </div>
        </div>
      </div>

      <!-- Issue Observed -->
      <div class="form-section">
        <h5>Issue Observed at Site by CE :</h5>
        <textarea class="form-control" name="issueObserved">${r.issue_observed || ''}</textarea>
      </div>

      <!-- Troubleshooting -->
      <div class="form-section">
        <h5>Troubleshooting Performed by CE :</h5>
        <textarea class="form-control" name="troubleshooting">${r.troubleshooting || ''}</textarea>
      </div>

      <!-- Resolution -->
      <div class="form-section">
        <h5>Resolution Summary :</h5>
        <textarea class="form-control" name="resolution">${r.resolution_summary || ''}</textarea>
      </div>

      <!-- Dates -->
      <div class="form-section">
        <h5>Dates</h5>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="arrivalDate-${index}">CE Arrival Date/Time :</label>
            <input type="datetime-local" class="form-control" id="arrivalDate-${index}" name="arrivalDate"
                   value="${r.ce_arrival ? new Date(r.ce_arrival).toISOString().slice(0,16) : ''}">
          </div>
          <div class="form-group col-md-6">
            <label for="solvedDate-${index}">CE Solved Date/Time :</label>
            <input type="datetime-local" class="form-control" id="solvedDate-${index}" name="solvedDate"
                   value="${r.ce_solved ? new Date(r.ce_solved).toISOString().slice(0,16) : ''}">
          </div>
        </div>
      </div>

      <!-- Parts -->
      <div id="partsContainer-${index}"></div>

      <!-- Case Status -->
      <div class="form-section">
        <h5>Case Status</h5>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="caseStatus-${index}">Case Status :</label>
            <select class="form-control" id="caseStatus-${index}" name="caseStatus">
              <option ${r.case_status==='Completed'?'selected':''}>Completed</option>
              <option ${r.case_status==='Add Part'?'selected':''}>Add Part</option>
              <option ${r.case_status==='Monitoring'?'selected':''}>Monitoring</option>
              <option ${r.case_status==='Reseller DOA'?'selected':''}>Reseller DOA</option>
              <option ${r.case_status==='Enduser DOA'?'selected':''}>Enduser DOA</option>
              <option ${r.case_status==='Request Quote'?'selected':''}>Request Quote</option>
              <option ${r.case_status==='Escalate to Mentor'?'selected':''}>Escalate to Mentor</option>
              <option ${r.case_status==='Escalate to EMT'?'selected':''}>Escalate to EMT</option>
              <option ${r.case_status==='WO Hold for Next Visit'?'selected':''}>WO Hold for Next Visit</option>
              <option ${r.case_status==='Loan SDD/HDD'?'selected':''}>Loan SDD/HDD</option>
              <option ${r.case_status==='Part Hold'?'selected':''}>Part Hold</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="endUser-${index}">End User :</label>
            <input type="text" class="form-control" id="endUser-${index}" name="endUser" value="${r.customer || ''}">
          </div>
        </div>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn btn-success mt-3">Generate Report</button>
    `;

    const partsContainer = form.querySelector(`#partsContainer-${index}`);

    // 🔑 Handle multiple part numbers and descriptions under same MO
    records.forEach((part, i) => {
      const partNumbers = (part.part_number || '').split(';').map(p => p.trim()).filter(p => p);
      const partDescriptions = (part.part_description || '').split(';').map(d => d.trim()).filter(d => d);

      const maxLen = Math.max(partNumbers.length, partDescriptions.length);
      for (let j = 0; j < maxLen; j++) {
        partsContainer.appendChild(createPartSection({
          ...part,
          part_number: partNumbers[j] || '',
          part_description: partDescriptions[j] || ''
        }, `${i}-${j}`));
      }
    });

    // ✅ Submit handler with Copy to Clipboard
    form.addEventListener("submit", function(e) {
        e.preventDefault();

        const formData = {};
        new FormData(form).forEach((value, key) => {
        if (formData[key]) {
            if (!Array.isArray(formData[key])) formData[key] = [formData[key]];
            formData[key].push(value);
        } else {
            formData[key] = value;
        }
        });

        // Normalize part fields
        const partFields = ["moNumber", "partNumber", "partDescription", "fid", "newCt", "oldCt", "partStatus"];
        partFields.forEach(field => {
        if (!Array.isArray(formData[field])) {
            formData[field] = formData[field] ? [formData[field]] : [];
        }
        });

        // 🔑 Handle multiple part numbers and descriptions split by ";"
        const partText = formData.moNumber.map((mo, i) => {
        const partNumbers = (formData.partNumber[i] || '').split(';').map(p => p.trim()).filter(p => p);
        const partDescriptions = (formData.partDescription[i] || '').split(';').map(d => d.trim()).filter(d => d);

        const maxLen = Math.max(partNumbers.length, partDescriptions.length);
        const blocks = [];
        for (let j = 0; j < maxLen; j++) {
            blocks.push(`
    MO NUMBER : ${mo}
    PART NUMBER : ${partNumbers[j] || ''}
    PART DESCRIPTION : ${partDescriptions[j] || ''}
    FID : ${formData.fid[i] || 'NIL'}
    NEW CT : ${formData.newCt[i] || 'NIL'}
    OLD CT : ${formData.oldCt[i] || 'NIL'}
    PART USED STATUS : ${formData.partStatus[i] || ''}
            `.trim());
        }
        return blocks.join("\n\n");
        }).join("\n\n");

        // Build full report
        const reportText = `
    CASE ID : ${formData.caseId || ''}

    WO : ${formData.wo || ''}

    CE : ${formData.ce || ''}

    LEARNER ID : ${formData.learnerId || ''}

    ISSUE OBSERVED AT SITE BY CE :
    • ${formData.issueObserved || ''}

    TROUBLESHOOTING PERFORMED BY CE :
    • ${formData.troubleshooting || ''}

    RESOLUTION SUMMARY :
    • ${formData.resolution || ''}

    CE ARRIVAL DATE/TIME : ${formData.arrivalDate ? new Date(formData.arrivalDate).toLocaleString() : ''}
    CE SOLVED DATE/TIME : ${formData.solvedDate ? new Date(formData.solvedDate).toLocaleString() : ''}

    ${partText}

    CASE STATUS : ${formData.caseStatus || ''}

    END USER : ${formData.endUser || ''}
        `.trim();

        // Create or update report container
        let reportContainer = form.querySelector(".report-output");
        if (!reportContainer) {
        reportContainer = document.createElement("div");
        reportContainer.classList.add("report-output");
        reportContainer.style.marginTop = "20px";

        const pre = document.createElement("pre");
        pre.style.whiteSpace = "pre-wrap";
        pre.style.border = "1px solid #ccc";
        pre.style.padding = "10px";
        pre.style.background = "#f9f9f9";
        pre.style.fontFamily = "monospace";
        pre.textContent = reportText;

        const copyBtn = document.createElement("button");
        copyBtn.textContent = "Copy to Clipboard";
        copyBtn.classList.add("btn", "btn-primary", "mt-2");
        copyBtn.addEventListener("click", () => {
            navigator.clipboard.writeText(pre.textContent)
            .then(() => alert("Report copied to clipboard!"))
            .catch(err => console.error("Copy failed:", err));
        });

        reportContainer.appendChild(pre);
        reportContainer.appendChild(copyBtn);
        form.appendChild(reportContainer);
        } else {
        const pre = reportContainer.querySelector("pre");
        pre.textContent = reportText;
        }
    });

    return form;
  }

  function createPartSection(part = {}, index = null) {
    const section = document.createElement("div");
    section.classList.add("form-section");

    const partNumbers = (part.part_number || '').split(';').map(p => p.trim()).filter(p => p);
    const partDescriptions = (part.part_description || '').split(';').map(d => d.trim()).filter(d => d);

    const maxLen = Math.max(partNumbers.length || 1, partDescriptions.length || 1);

    for (let i = 0; i < maxLen; i++) {
      const pn = partNumbers[i] || '';
      const pd = partDescriptions[i] || '';

      const block = document.createElement("div");
      block.classList.add("form-row");
      block.innerHTML = `
        <h5>Part Status</h5>
        <div class="form-row">
          <div class="form-group col-md-3">
            <label>MO Number :</label>
            <input type="text" class="form-control" name="moNumber" value="${part.material_order_no || ''}">
          </div>
          <div class="form-group col-md-3">
            <label>Part Number :</label>
            <input type="text" class="form-control" name="partNumber" value="${pn}">
          </div>
          <div class="form-group col-md-3">
            <label>Part Description :</label>
            <textarea class="form-control" name="partDescription" rows="2">${pd}</textarea>
          </div>
          <div class="form-group col-md-3">
            <label>FID :</label>
            <input type="text" class="form-control" name="fid" value="${part.fid || ''}">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label>New CT :</label>
            <input type="text" class="form-control" name="newCt" value="${part.new_ct || ''}">
          </div>
          <div class="form-group col-md-4">
            <label>Old CT :</label>
            <input type="text" class="form-control" name="oldCt" value="${part.old_ct || ''}">
          </div>
          <div class="form-group col-md-4">
            <label>Part Used Status :</label>
            <select class="form-control" name="partStatus">
              <option ${part.part_status===''?'selected':''}>Select Status</option>
              <option ${part.part_status==='Good'?'selected':''}>Good</option>
              <option ${part.part_status==='Bad'?'selected':''}>Bad</option>
              <option ${part.part_status==='DOA'?'selected':''}>DOA</option>
              <option ${part.part_status==='NPR'?'selected':''}>NPR</option>
              <option ${part.part_status==='Bad APD'?'selected':''}>Bad APD</option>
              <option ${part.part_status==='Hold Part for Next Visit'?'selected':''}>Hold Part for Next Visit</option>
              <option ${part.part_status==='NIL'?'selected':''}>NIL</option>
            </select>
          </div>
        </div>
      `;
      section.appendChild(block);
    }

    return section;
  }

  function addPart(formIndex) {
    const container = document.getElementById(`partsContainer-${formIndex}`);
    const index = container.children.length;
    container.appendChild(createPartSection({}, index));
  }

  // ✅ Only one listener, wrapped in DOMContentLoaded
  document.addEventListener("DOMContentLoaded", () => {
    const searchBtn = document.getElementById("searchBtn");
    if (searchBtn) {
      searchBtn.addEventListener("click", () => {
        const caseIdInput = document.getElementById("caseId");
        if (!caseIdInput || !caseIdInput.value) {
          alert("Please enter a Case ID");
          return;
        }

        fetch(`/case-report/${caseIdInput.value}`)
          .then(res => res.json())
          .then(groupedData => {
            if (groupedData.error) {
              alert(groupedData.error);
              return;
            }

            const tabs = document.getElementById("woTabs");
            const tabContent = document.getElementById("woTabContent");
            tabs.innerHTML = "";
            tabContent.innerHTML = "";

            const woKeys = Object.keys(groupedData);

            if (woKeys.length === 1) {
              const form = createForm(woKeys[0], groupedData[woKeys[0]], 0);
              tabContent.appendChild(form);
            } else {
              woKeys.forEach((wo, idx) => {
                const tab = document.createElement("li");
                tab.classList.add("nav-item");
                tab.innerHTML = `<a class="nav-link ${idx===0?'active':''}" data-toggle="tab" href="#content-${idx}">Form ${idx+1}</a>`;
                tabs.appendChild(tab);

                const content = document.createElement("div");
                content.classList.add("tab-pane", "fade");
                if (idx === 0) content.classList.add("show", "active");
                content.id = `content-${idx}`;
                content.appendChild(createForm(wo, groupedData[wo], idx));
                tabContent.appendChild(content);
              });
            }
          })
          .catch(err => console.error("Fetch error:", err));
      });
    }
  });

  document.addEventListener("DOMContentLoaded", () => {
    const searchBtn = document.getElementById("searchBtn");
    if (searchBtn) {
      searchBtn.addEventListener("click", () => {
        const caseIdInput = document.getElementById("caseId");
        if (!caseIdInput || !caseIdInput.value) {
          alert("Please enter a Case ID");
          return;
        }

        fetch(`/case-report/${caseIdInput.value}`)
          .then(res => res.json())
          .then(groupedData => {
            if (groupedData.error) {
              alert(groupedData.error);
              return;
            }
            // render your tabs/forms here
            console.log("Data received:", groupedData);
          })
          .catch(err => console.error("Fetch error:", err));
      });
    }
  });
