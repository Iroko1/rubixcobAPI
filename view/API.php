<div class="container">
        <h2>API Dashboard</h2>
        
        <!-- API Endpoints Table -->
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th class="col">API Endpoint</th>
                    <th class="col">Request Type</th>
                    <th class="col">Description</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'model/api_endpoints.php'; ?>
            </tbody>
        </table>

        <h2>API Requests</h2>
        <!-- API Requests Table -->
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th class="col">Date</th>
                    <th class="col">Request Data</th>
                    <th class="col">Delete Records</th>
                </tr>
            </thead>
            <tbody>
                <?php include 'model/api_requests.php'; ?>
            </tbody>
        </table>
    </div>
