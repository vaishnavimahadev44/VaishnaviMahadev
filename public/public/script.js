document.addEventListener('DOMContentLoaded', function() {
    
    if (localStorage.getItem('adminLoggedIn') !== 'true') {
        window.location.href = 'login.html';
        return;
    }

    
    const adminUsername = localStorage.getItem('adminUsername');
    document.querySelector('#adminUsername span').textContent = adminUsername || 'Admin';

    
    document.getElementById('logoutBtn').addEventListener('click', function() {
        localStorage.removeItem('adminLoggedIn');
        localStorage.removeItem('adminUsername');
        window.location.href = 'login.html';
    });

    
    const menuItems = document.querySelectorAll('.sidebar .item');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            
            menuItems.forEach(i => i.classList.remove('active'));
            
            this.classList.add('active');

            
            const page = this.getAttribute('data-page');
            handlePageChange(page);
        });
    });
});

function handlePageChange(page) {
    
    const packageContent = `
        <div class="ui grid">
            <div class="sixteen wide column">
                <h1 class="ui header">Package Management</h1>
                <div class="ui divider"></div>
            </div>
            <div class="ten wide column">
                <h2 class="ui header">Package List</h2>
                <div class="ui segment">
                    <div id="packageList" class="ui relaxed divided list"></div>
                </div>
            </div>
            <div class="six wide column">
                <h2 class="ui header">Package Details</h2>
                <div class="ui segment">
                    <div class="ui form">
                        <div class="field">
                            <label>Package Title</label>
                            <input type="text" id="packageTitle" placeholder="Enter package title">
                        </div>
                        <div class="field">
                            <label>Package Contents</label>
                            <textarea id="packageContents" rows="6" placeholder="Enter package contents"></textarea>
                        </div>
                        <div class="field">
                            <label>Package Price (£)</label>
                            <input type="number" id="packagePrice" placeholder="Enter package price" step="0.01" min="0">
                        </div>
                        <div class="field">
                            <label>Package Image</label>
                            <input type="file" id="packageImage" accept="image/*">
                            <div id="imagePreview" class="ui medium rounded image" style="display: none; margin-top: 10px;"></div>
                        </div>
                        <div class="field">
                            <label>Additional Information</label>
                            <textarea id="packageAdditionalInfo" rows="4" placeholder="Enter any additional information"></textarea>
                        </div>
                        <button class="ui primary fluid button" id="createPackage">
                            <i class="plus icon"></i>
                            <span>Create Package</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

    const mainContent = document.querySelector('.main-content .ui.container');
    
    switch(page) {
        case 'dashboard':
            mainContent.innerHTML = `
                <h1 class="ui header">Dashboard Overview</h1>
                <div class="ui statistics">
                    <div class="statistic">
                        <div class="value">
                            <i class="box icon"></i> 42
                        </div>
                        <div class="label">Total Packages</div>
                    </div>
                    <div class="statistic">
                        <div class="value">
                            <i class="users icon"></i> 100
                        </div>
                        <div class="label">Users</div>
                    </div>
                </div>
            `;
            break;
            
        case 'packages':
            mainContent.innerHTML = packageContent;
            
            initializePackageManagement();
            break;
            
        case 'users':
            mainContent.innerHTML = `
                <h1 class="ui header">User Management</h1>
                <div class="ui segment">
                    <div class="ui relaxed divided list">
                        <div class="item">
                            <i class="large user middle aligned icon"></i>
                            <div class="content">
                                <a class="header">User Management Coming Soon</a>
                                <div class="description">This feature is under development</div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            break;
            
        case 'statistics':
            mainContent.innerHTML = `
                <h1 class="ui header">Statistics</h1>
                <div class="ui segment">
                    <div class="ui placeholder">
                        <div class="image header">
                            <div class="line"></div>
                            <div class="line"></div>
                        </div>
                        <div class="paragraph">
                            <div class="line"></div>
                            <div class="line"></div>
                            <div class="line"></div>
                        </div>
                    </div>
                </div>
            `;
            break;
            
        case 'settings':
            mainContent.innerHTML = `
                <h1 class="ui header">Settings</h1>
                <div class="ui segment">
                    <div class="ui form">
                        <h4 class="ui dividing header">General Settings</h4>
                        <div class="field">
                            <label>Site Title</label>
                            <input type="text" placeholder="Site Title">
                        </div>
                        <div class="field">
                            <label>Admin Email</label>
                            <input type="email" placeholder="Admin Email">
                        </div>
                        <button class="ui primary button">Save Settings</button>
                    </div>
                </div>
            `;
            break;
    }
}


function initializePackageManagement() {
    
    const createPackageBtn = document.getElementById('createPackage');
    if (createPackageBtn) {
        createPackageBtn.addEventListener('click', handleCreatePackage);
    }

    const packageImage = document.getElementById('packageImage');
    if (packageImage) {
        packageImage.addEventListener('change', handleImagePreview);
    }

    
    loadPackages();
}


function handleCreatePackage() {
    
}

function handleImagePreview(event) {
    
}

function loadPackages() {
    
}

document.addEventListener('DOMContentLoaded', function() {
    const createPackageBtn = document.getElementById('createPackage');
    const packageList = document.getElementById('packageList');

    let packages = [];
    let selectedPackageIndex = -1;

    createPackageBtn.addEventListener('click', createOrUpdatePackage);

    const imageInput = document.getElementById('packageImage');
    const imagePreview = document.getElementById('imagePreview');

    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.style.display = 'block';
                imagePreview.innerHTML = `<img src="${e.target.result}" class="ui image" style="max-width: 100%; height: auto;">`;
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
            imagePreview.innerHTML = '';
        }
    });

    function createOrUpdatePackage() {
        const title = document.getElementById('packageTitle').value;
        const contents = document.getElementById('packageContents').value;
        const price = document.getElementById('packagePrice').value;
        const imageFile = document.getElementById('packageImage').files[0];
        const additionalInfo = document.getElementById('packageAdditionalInfo').value;

        if (title && contents && price) {
            if (selectedPackageIndex === -1) {
                
                if (isDuplicatePackage(title)) {
                    if (!confirm('A package with this title already exists. Do you want to create it anyway?')) {
                        return;
                    }
                }
            } else {
                
                if (isDuplicatePackage(title, selectedPackageIndex)) {
                    alert('Another package with this title already exists. Please choose a different title.');
                    return;
                }
            }

            const packageData = { title, contents, price, additionalInfo };
            
            if (imageFile) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    packageData.image = e.target.result;
                    finalizePackageCreation(packageData);
                };
                reader.readAsDataURL(imageFile);
            } else {
                finalizePackageCreation(packageData);
            }
        } else {
            alert('Please fill in all required fields');
        }
    }

    function finalizePackageCreation(packageData) {
        if (selectedPackageIndex === -1) {
            packages.push(packageData);
        } else {
            packages[selectedPackageIndex] = packageData;
            selectedPackageIndex = -1;
            createPackageBtn.textContent = 'Create Package';
        }
        updatePackageList();
        clearForm();
        savePackagesToLocalStorage();
    }

    function updatePackageList() {
        packageList.innerHTML = '';
        packages.forEach((pkg, index) => {
            const item = document.createElement('div');
            item.className = 'item package-item';
            item.dataset.index = index;
            item.innerHTML = `
                <div class="ui grid">
                    <div class="six wide column">
                        <div class="ui image package-image" style="cursor: pointer;">
                            ${pkg.image ? `<img src="${pkg.image}" alt="${pkg.title}">` : '<div class="ui placeholder"></div>'}
                        </div>
                    </div>
                    <div class="eight wide column">
                        <div class="content">
                            <h3 class="ui header">${pkg.title}</h3>
                            <div class="description">${pkg.contents.substring(0, 100)}${pkg.contents.length > 100 ? '...' : ''}</div>
                            <div class="meta">
                                <span class="price">Price: £${pkg.price}</span>
                            </div>
                        </div>
                    </div>
                    <div class="two wide column">
                        <div class="ui mini vertical buttons">
                            <button class="ui icon button blue edit-package" data-index="${index}">
                                <i class="edit icon"></i>
                            </button>
                            <button class="ui icon button red remove-package" data-index="${index}">
                                <i class="trash alternate icon"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            packageList.appendChild(item);

            
            if (pkg.image) {
                item.querySelector('.package-image').addEventListener('click', function() {
                    displayFullSizeImage(pkg.image);
                });
            }
        });

        
        document.querySelectorAll('.edit-package').forEach(button => {
            button.addEventListener('click', editPackage);
        });
        document.querySelectorAll('.remove-package').forEach(button => {
            button.addEventListener('click', removePackage);
        });
    }

    function editPackage(event) {
        event.stopPropagation();
        const index = parseInt(event.currentTarget.dataset.index);
        selectedPackageIndex = index;
        const packageToEdit = packages[selectedPackageIndex];

        document.getElementById('packageTitle').value = packageToEdit.title;
        document.getElementById('packageContents').value = packageToEdit.contents;
        document.getElementById('packagePrice').value = packageToEdit.price;
        document.getElementById('packageAdditionalInfo').value = packageToEdit.additionalInfo || '';

        if (packageToEdit.image) {
            imagePreview.style.display = 'block';
            imagePreview.innerHTML = `<img src="${packageToEdit.image}" class="ui image" style="max-width: 100%; height: auto;">`;
        } else {
            imagePreview.style.display = 'none';
            imagePreview.innerHTML = '';
        }
        createPackageBtn.innerHTML = '<i class="save icon"></i><span>Update Package</span>';
    }

    function removePackage(event) {
        event.stopPropagation();
        const index = parseInt(event.currentTarget.dataset.index);
        
        if (confirm(`Are you sure you want to remove this package?`)) {
            packages.splice(index, 1);
            updatePackageList();
            clearForm();
            savePackagesToLocalStorage();
        }
    }

    function clearForm() {
        document.getElementById('packageTitle').value = '';
        document.getElementById('packageContents').value = '';
        document.getElementById('packagePrice').value = '';
        document.getElementById('packageImage').value = '';
        document.getElementById('packageAdditionalInfo').value = '';
        selectedPackageIndex = -1;
        createPackageBtn.textContent = 'Create Package';
        imagePreview.style.display = 'none';
        imagePreview.innerHTML = '';
        createPackageBtn.innerHTML = '<i class="plus icon"></i><span>Create Package</span>';
    }

    function isDuplicatePackage(title, excludeIndex = -1) {
        return packages.some((pkg, index) => 
            index !== excludeIndex && pkg.title.toLowerCase() === title.toLowerCase()
        );
    }

    function savePackagesToLocalStorage() {
        localStorage.setItem('packages', JSON.stringify(packages));
    }

    function loadPackagesFromLocalStorage() {
        const storedPackages = localStorage.getItem('packages');
        if (storedPackages) {
            packages = JSON.parse(storedPackages);
            updatePackageList();
        }
    }

    function displayFullSizeImage(imageUrl) {
        const modal = document.createElement('div');
        modal.className = 'ui modal';
        modal.innerHTML = `
            <i class="close icon"></i>
            <div class="content" style="text-align: center;">
                <img src="${imageUrl}" style="max-width: 100%; height: auto;">
            </div>
        `;
        document.body.appendChild(modal);
        $(modal).modal('show');
    }

    
    loadPackagesFromLocalStorage();
});

$(document).ready(function() {
    $('.ui.modal').modal();
});
