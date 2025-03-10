const submit_btn = document.getElementById("submit");
const data_table = document.getElementById("data");
const userSelect = document.getElementById("user");

const updateTable = (data, userName) => {
    const table = data_table.querySelector('table');
    const tbody = table.querySelector('tbody') || table.createTBody();
    
    // Clear existing rows
    tbody.innerHTML = '';
    
    // Add new rows
    data.forEach(item => {
        const row = tbody.insertRow();
        row.insertCell().textContent = item.month;
        row.insertCell().textContent = item.balance;
        row.insertCell().textContent = item.transaction_count;
    });
    
    // Update heading
    data_table.querySelector('h2').textContent = `Transactions of ${userName}`;
    data_table.style.display = "block";
};

submit_btn.onclick = async function (e) {
    e.preventDefault();
    
    const userId = userSelect.value;
    const userName = userSelect.options[userSelect.selectedIndex].text;
    
    try {
        const response = await fetch(`data.php?user=${userId}`);
        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
        
        const result = await response.json();
        if (result.status !== 'success') throw new Error(result.message || 'Unknown error');
        
        updateTable(result.data, userName);
    } catch (error) {
        console.error('Error:', error);
        alert('Error: ' + error.message);
    }
};
