(function(window){var svgSprite="<svg>"+""+'<symbol id="icon-food" viewBox="0 0 1024 1024">'+""+'<path d="M400.704 966.688l0 25.184 312.16 0 0-25.184c159.84-56.992 279.424-198.56 304.32-371.072L96.512 595.616C121.408 768.128 240.896 909.696 400.704 966.688z"  ></path>'+""+'<path d="M1022.08 528.832 91.584 528.832c0 11.264 0.512 22.336 1.312 33.408l927.808 0C1021.536 551.2 1022.08 540.096 1022.08 528.832z"  ></path>'+""+'<path d="M507.552 275.488c-39.36-68.928-68.544-68.288-85.12-35.968l16.448 49.952C438.88 289.472 500.384 346.24 507.552 275.488z"  ></path>'+""+'<path d="M931.456 236.16c-41.216-38.656-17.152 43.808 0 66.624 17.248 22.848-91.936 52-97.216-53.088-5.344-105.056-117.664-92.544-131.488-13.536-0.704 4.768-1.536 9.184-2.432 13.344 17.248 11.072 30.368 32.608 32.128 66.72 4 77.344 63.968 81.92 88.576 69.824 3.008 6.176 6.016 11.584 8.8 15.296 17.248 22.752-91.968 52-97.376-53.056-1.76-34.24-14.88-55.68-32.128-66.752-19.808-12.8-45.312-11.328-65.664 1.536-16.352 10.336-29.376 27.968-33.6 51.68-13.92 79.072-28.8 86.528-92.992-26.432-0.096-0.32-0.288-0.544-0.512-0.832-7.2 70.688-68.672 14.016-68.672 14.016l-16.448-49.984c-10.304 20.064-15.744 52.192-15.744 87.808 0 92.8-69.44 28.672-69.44 28.672l-26.88-80.992c0 0-24.064-20.192-39.392-27.136C261.632 275.68 255.712 276.416 260.128 289.472c-16.64 21.248-18.752 61.024-18.944 77.536-8.288-6.016-18.656-12.256-32.256-18.688-74.72-35.616-69.472 92.832-69.472 92.832L139.392 499.52l758.56 0 49.376-66.56 13.632-18.24c0 0-89.728-41.408-131.168-79.904-9.824-8.96-15.712-11.232-19.264-9.184-6.912-25.216-5.92-46.048 19.264-22.848 41.44 38.464 125.088 178.432 125.088 178.432l-13.536 18.304 52.288 0C993.664 499.52 1068.736 365.312 931.456 236.16z"  ></path>'+""+'<path d="M601.056 302.784c4.224-23.744 17.248-41.312 33.6-51.68-7.392-11.488-15.52-25.024-24.8-41.344-64.064-112.992-101.568-41.856-101.568 50.944 0 5.536-0.32 10.336-0.704 14.784 0.224 0.256 0.416 0.512 0.512 0.8C572.256 389.28 587.168 381.824 601.056 302.784z"  ></path>'+""+'<path d="M337.248 356.128c0 0 69.44 64.096 69.44-28.864 0-35.456 5.44-67.648 15.744-87.712l-10.176-30.944c0 0-80.16-67.456-41.408 1.184 38.912 68.672-1.344 106.24-1.344 106.24s15.968-30.624-58.848-66.304c-17.152-8.16-29.888-7.424-39.68-1.824 15.328 7.008 39.392 27.168 39.392 27.168L337.248 356.128z"  ></path>'+""+'<path d="M98.735498 32.106122l178.063744 406.894976-96.828106 42.373526-178.063744-406.894976 96.828106-42.373526Z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-shopping01" viewBox="0 0 1024 1024">'+""+'<path d="M437.30944 801.71008c-41.34912 0-75.01824 33.64864-75.01824 75.01824s33.64864 75.01824 75.01824 75.01824 75.01824-33.64864 75.01824-75.01824S478.65856 801.71008 437.30944 801.71008zM437.30944 908.86144c-17.73568 0-32.1536-14.41792-32.1536-32.1536 0-17.73568 14.41792-32.1536 32.1536-32.1536 17.73568 0 32.1536 14.41792 32.1536 32.1536C469.46304 894.44352 455.04512 908.86144 437.30944 908.86144z"  ></path>'+""+'<path d="M739.69664 801.71008c-41.34912 0-75.01824 33.64864-75.01824 75.01824s33.64864 75.01824 75.01824 75.01824 75.01824-33.64864 75.01824-75.01824S781.04576 801.71008 739.69664 801.71008zM739.69664 908.86144c-17.73568 0-32.1536-14.41792-32.1536-32.1536 0-17.73568 14.41792-32.1536 32.1536-32.1536 17.73568 0 32.1536 14.41792 32.1536 32.1536C771.85024 894.44352 757.41184 908.86144 739.69664 908.86144z"  ></path>'+""+'<path d="M957.89056 357.43744c-16.73216-25.3952-44.89216-40.57088-75.32544-40.57088L379.26912 316.86656c-11.83744 0-21.42208 9.60512-21.42208 21.42208 0 11.83744 9.60512 21.42208 21.42208 21.42208l503.31648 0c15.9744 0 30.74048 7.94624 39.5264 21.27872 8.78592 13.33248 10.26048 30.06464 3.95264 44.72832L800.07168 719.0528c-3.11296 7.24992-8.25344 13.39392-14.82752 17.73568-6.59456 4.36224-14.25408 6.656-22.15936 6.656L418.05824 743.44448c-14.80704 0-28.83584-4.79232-40.57088-13.86496-11.73504-9.07264-19.88608-21.44256-23.61344-35.77856l-120.91392-465.01888c-3.64544-14.0288-11.30496-26.50112-22.17984-36.10624C199.92576 183.11168 186.59328 177.0496 172.2368 175.16544l-96.82944-12.6976C63.67232 160.95232 52.92032 169.18528 51.38432 180.92032c-1.536 11.73504 6.73792 22.48704 18.47296 24.04352l96.82944 12.6976c5.85728 0.75776 11.30496 3.23584 15.74912 7.168 4.44416 3.91168 7.55712 8.99072 9.05216 14.72512l120.91392 465.01888c6.12352 23.61344 19.57888 43.97056 38.87104 58.90048 19.31264 14.92992 42.3936 22.81472 66.78528 22.81472L763.0848 786.28864c16.30208 0 32.11264-4.75136 45.75232-13.7216 13.6192-8.97024 24.20736-21.64736 30.63808-36.59776l125.99296-293.31456C977.44896 414.72 974.62272 382.85312 957.89056 357.43744z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-yishouqingfff" viewBox="0 0 1039 1024">'+""+'<path d="M1001.600851 430.91731 226.625484 921.699056c-21.35333 13.522991-49.727565 7.151887-63.250556-14.201443L8.123005 662.346193c-13.522991-21.35333-7.151887-49.727565 14.201443-63.250556L797.299815 108.313891c21.35333-13.522991 49.727565-7.151887 63.250556 14.201443l155.251923 245.151419C1029.325285 389.020084 1022.954181 417.394319 1001.600851 430.91731zM39.034015 625.480564c-6.804986 4.309142-8.835226 13.351076-4.526083 20.157085l155.2509 245.151419c4.309142 6.804986 13.352099 8.835226 20.157085 4.526083l774.975367-490.782769c6.804986-4.309142 8.835226-13.352099 4.526083-20.157085L834.165444 139.223878c-4.309142-6.804986-13.352099-8.835226-20.157085-4.526083L39.034015 625.480564z"  ></path>'+""+'<path d="M165.531034 676.740018l14.558577 22.988574c0.654916 0.735757 1.463328 0.799202 2.422166 0.191358l115.762537-73.310679c0.920976-0.966001 1.170662-2.081405 0.753153-3.352351l-30.15581-47.618531c-0.829901-1.006933-1.812275-1.342578-2.942005-1.013073L117.325126 668.732647c-0.820692 0.51984-1.49198 0.369414-2.01182-0.451278l-13.517875-21.346167c-0.51984-0.820692-0.369414-1.49198 0.451278-2.01182L282.048771 531.058055c1.042749-0.467651 1.938142-0.267083 2.682086 0.601704l54.592362 86.205361c4.675486 9.504468 2.6432 17.499559-6.089695 23.987321l-133.414569 84.489276c-1.010003 0.831948-1.345648 1.813299-1.013073 2.942005l32.496112 51.312666c1.226944 1.334391 2.705622 1.548262 4.433986 0.64366l149.424194-94.628194c0.820692-0.51984 1.578961-0.232291 2.27174 0.862647l14.948457 23.603581c0.51984 0.820692 0.369414 1.49198-0.451278 2.01182L234.44252 819.156612c-10.782577 5.678326-19.682271 3.737114-26.689872-5.816472l-73.830519-116.583229c-0.692778-1.093914-0.629333-1.902326 0.191358-2.422166l29.145807-18.457374C164.079986 675.357532 164.838256 675.646104 165.531034 676.740018z"  ></path>'+""+'<path d="M395.32672 524.310374l-8.209986 5.199419c-1.131777 0.334621-2.112104 0-2.942005-1.013073l-12.738116-20.114107c-0.470721-1.041726-0.26913-1.937119 0.601704-2.682086l6.568602-4.15974c2.972705-2.2656 4.345981-5.240351 4.118807-8.93551l-0.464581-26.161846c-0.195451-1.216711 0.278339-2.284019 1.423419-3.201925l25.862018-16.378016c1.49198-0.369414 2.422166 0.191358 2.791579 1.683339l1.108241 4.474918c0.418532 1.270946 1.261737 1.694595 2.53166 1.272993l34.072003-21.577434c1.366114-0.865717 1.892093-2.156106 1.573845-3.872191l-2.340301-3.695159c-0.730641-1.452071-0.429789-2.792603 0.903579-4.022617l26.272363-16.637935c1.540076-0.590448 2.88163-0.288572 4.022617 0.903579l2.600221 4.105504c1.325182 0.886183 2.631944 0.826831 3.913123-0.178055l59.934021-37.95545c1.267876-0.417509 2.471284-0.028653 3.612271 1.163499l11.698436 18.472723c0.50449 1.406023 0.340761 2.659573-0.493234 3.762697l-59.934021 37.95545c-1.467421 1.314948-1.906419 2.743484-1.313925 4.282536l2.859118 4.514827c1.413186 1.025353 2.804882 1.100054 4.174066 0.232291l59.113329-37.435611c1.541099-0.588401 2.88163-0.287549 4.022617 0.903579l11.69946 18.473747c0.678452 1.681292 0.3776 3.021823-0.903579 4.021593l-59.113329 37.435611c-1.194198 1.144056-1.633197 2.572592-1.313925 4.282536l3.120061 4.926196c1.585101 1.296529 3.064802 1.5104 4.433986 0.64366l59.934021-37.95545c1.043772-0.467651 1.939165-0.267083 2.682086 0.601704l11.698436 18.472723c0.469698 1.045819 0.26913 1.942235-0.602727 2.682086l-59.934021 37.95545c-1.467421 1.315972-1.905396 2.744507-1.313925 4.282536l2.600221 4.105504c1.226944 1.334391 2.705622 1.548262 4.433986 0.64366l59.934021-37.95545c1.130753-0.330528 2.112104 0.00614 2.942005 1.013073l10.138918 16.009625c0.729617 1.456165 0.613984 2.486634-0.341784 3.092431l-145.729036 92.288916 2.079358 3.28379c0.331551 1.133823-0.004093 2.114151-1.013073 2.942005l-25.862018 16.378016c-0.958838 0.606821-1.940189 0.271176-2.942005-1.013073l-48.874127-77.174684C397.538085 523.871375 396.507616 523.755742 395.32672 524.310374zM628.230188 497.020844l21.056572 33.250288c7.758708 14.06739 4.605901 25.741267-9.448186 35.029818l-154.760736 98.008174c-1.046842 0.468674-1.942235 0.267083-2.682086-0.601704l-33.145911-52.339042c-0.470721-1.041726-0.26913-1.937119 0.601704-2.682086l175.286212-111.00621C626.318652 496.123404 627.349121 496.239038 628.230188 497.020844zM493.474065 615.718223l4.158716 6.567579c1.538029 1.520633 3.37691 1.699712 5.514597 0.534166l113.709785-72.01108c1.691525-1.25969 2.043542-2.825348 1.054005-4.693906l-4.158716-6.567579c-1.003863-1.279133-2.482541-1.493004-4.433986-0.64366l-113.709785 72.01108C493.730914 612.490715 493.018693 614.091166 493.474065 615.718223zM472.160643 461.273688l-2.859118-4.514827c-1.003863-1.279133-2.482541-1.493004-4.433986-0.64366l-45.976124 29.116131c-1.605567 1.402953-2.044566 2.830465-1.313925 4.282536l2.859118 4.514827c1.413186 1.025353 2.803859 1.100054 4.174066 0.232291l45.976124-29.116131C471.952912 464.281185 472.478891 462.99182 472.160643 461.273688zM491.917616 492.472248l-3.120061-4.926196c-1.413186-1.01819-2.891863-1.232061-4.433986-0.64366l-46.38647 29.376051c-1.056052 1.056052-1.357927 2.397606-0.903579 4.022617l3.120061 4.926196c1.450025 1.382487 2.791579 1.683339 4.022617 0.903579l46.38647-29.376051C491.970828 495.890091 492.408803 494.462578 491.917616 492.472248zM511.415692 523.260461l-2.600221-4.105504c-1.00284-1.278109-2.481518-1.49198-4.433986-0.64366l-46.38647 29.376051c-1.332345 1.231037-1.633197 2.572592-0.903579 4.022617l2.600221 4.105504c1.088798 1.421372 2.430352 1.722224 4.022617 0.903579l46.38647-29.376051C511.793292 526.283308 512.231267 524.854772 511.415692 523.260461z"  ></path>'+""+'<path d="M710.122313 408.925437l-2.24411 3.721765c-1.849114 4.047176-4.799306 7.258311-8.853645 9.632381l-13.956873 8.839319c-1.455141 0.731664-2.745531 0.205685-3.872191-1.573845l-10.398838-16.420995c-0.951675-1.503237-0.876973-2.895957 0.232291-4.173043l4.51585-2.860141c1.893116-2.155083 1.968841-3.546779 0.232291-4.174066l-17.937534-28.324092c-0.470721-1.041726-0.270153-1.937119 0.601704-2.682086l85.384669-54.073546c1.042749-0.467651 1.938142-0.26606 2.682086 0.601704l18.457374 29.144784c6.39464 12.82305 3.675716 23.36515-8.15575 31.623231l-44.745087 28.336372C711.055568 407.377174 710.406792 408.170237 710.122313 408.925437zM752.758366 389.974829l117.815289-74.611302c1.043772-0.466628 1.939165-0.265036 2.682086 0.601704l10.658757 16.83134c0.468674 1.045819 0.268106 1.941212-0.601704 2.682086l-72.249511 45.75509c-0.871857 0.744967-1.072425 1.64036-0.601704 2.682086l2.079358 3.282766c0.74292 0.873903 1.638313 1.075495 2.682086 0.601704l74.711586-47.314609c1.319042-0.64059 2.350534-0.525979 3.092431 0.341784l9.359158 14.778588c0.556679 1.183965 0.305969 2.299369-0.753153 3.352351l-74.711586 47.314609c-0.871857 0.744967-1.072425 1.64036-0.602727 2.682086l5.198395 8.208962c0.654916 0.735757 1.506307 0.86674 2.552126 0.397043l38.176484-24.176632c1.316995-0.644683 1.837858-1.639337 1.553379-2.996241l-2.860141-4.51585c-0.059352-1.300622 0.639566-2.318812 2.094708-3.050476l27.91477-17.677615c1.12973-0.329505 2.198062 0.144286 3.200902 1.422396l4.549619 7.184633c5.985318 10.969842 3.705392 20.084431-6.841825 27.339672L740.940203 502.998999c-1.817392 0.763386-3.209088 0.687662-4.174066-0.232291l-13.648858-21.552875c-0.592494-1.538029-0.153496-2.966565 1.314948-4.281513l25.862018-16.378016c1.180895-0.554632 2.296299-0.304945 3.351328 0.75213l2.860141 4.51585c0.394996 0.325411 1.073448 0.183172 2.032286-0.423649l39.818891-25.217335c0.868787-0.74292 1.11438-1.568728 0.732687-2.476401l-5.198395-8.208962c-1.103124-0.833995-2.27174-0.861624-3.502777-0.081864l-75.5333 47.834448c-1.131777 0.334621-2.113127-0.002047-2.942005-1.013073l-9.359158-14.778588c-0.881067-0.780783-0.817622-1.588171 0.191358-2.422166l2.873444-1.819438c1.25662-1.946328 1.113357-3.38612-0.436952-4.322445l-8.839319-13.957897c-0.604774-0.954745-0.270153-1.937119 1.013073-2.942005l14.778588-9.359158c2.462075-1.559519 3.972475-4.624321 4.529153-9.195429l2.408863-10.726296c0.387833-1.203408 1.036609-1.99647 1.943258-2.381234l26.682709-16.897855c1.989307-0.49221 3.242857-0.328481 3.762697 0.493234l-1.272993 2.530636C750.123352 391.263172 750.978836 391.102512 752.758366 389.974829zM736.081545 313.691445l-84.974323 53.813626c-0.958838 0.607844-1.940189 0.271176-2.942005-1.013073l-9.358135-14.777565c-0.470721-1.041726-0.270153-1.937119 0.601704-2.682086l27.504424-17.417695c1.280156-1.000793 1.75497-2.068102 1.422396-3.201925l-2.600221-4.105504c-0.881067-0.781806-2.048659-0.810459-3.502777-0.082888l-30.788214 19.498076c-0.906649 0.384763-1.663896 0.096191-2.27174-0.862647l-9.618055-15.187911c-0.332575-1.128707 0.00307-2.110057 1.013073-2.942005l31.198559-19.757996c1.042749-0.467651 1.418302-1.087774 1.121544-1.860371l-3.120061-4.926196c-0.730641-1.452071-0.529049-2.347464 0.601704-2.682086l25.451672-16.118096c1.042749-0.467651 1.939165-0.267083 2.682086 0.601704l2.600221 4.105504c1.052982 1.059122 2.082428 1.174756 3.092431 0.341784l27.91477-17.677615c1.042749-0.467651 1.938142-0.267083 2.682086 0.601704l9.618055 15.187911c0.468674 1.045819 0.268106 1.941212-0.602727 2.682086l-28.325116 17.937534c-0.871857 0.744967-1.073448 1.64036-0.601704 2.682086l2.600221 4.105504c0.741897 0.873903 1.63729 1.074472 2.682086 0.601704l24.219611-15.338337c1.042749-0.467651 1.939165-0.267083 2.682086 0.601704l9.358135 14.777565C737.152946 312.055179 737.037313 313.085648 736.081545 313.691445zM699.914834 372.829334l-3.694135 2.339278c-1.282203 1.004887-1.617847 1.985214-1.013073 2.942005l4.15974 6.568602c0.606821 0.958838 1.63729 1.074472 3.091408 0.340761l3.28379-2.079358c1.00898-0.826831 1.344624-1.807159 1.013073-2.940982l-4.15974-6.568602C701.853999 372.562251 700.957583 372.361683 699.914834 372.829334zM747.079016 430.956196l32.429597-20.537755c0.870834-0.738827 1.072425-1.635243 0.601704-2.682086l-2.079358-3.282766c-0.74292-0.868787-1.639337-1.069355-2.682086-0.601704l-26.272363 16.637935c-1.420349 1.091868-2.068102 1.88493-1.943258 2.381234l-1.915629 6.963599C745.18897 431.002244 745.810117 431.378821 747.079016 430.956196zM732.345454 352.291578l-4.105504 2.600221c-0.971118 1.190105-0.99977 2.358721-0.081864 3.502777l3.6399 5.746888c0.741897 0.873903 1.63729 1.074472 2.681062 0.600681l4.105504-2.600221c0.870834-0.738827 1.071402-1.63422 0.602727-2.681062l-4.15974-6.568602C734.283596 352.024495 733.388203 351.823927 732.345454 352.291578zM753.472634 319.356468l-9.878998-15.598256c-1.090844-1.417279-0.974188-2.446725 0.341784-3.092431l82.922594-52.514027c0.955768-0.604774 1.76418-0.542352 2.422166 0.191358l10.398838 16.419971c0.967024 0.925069 1.387603 2.191922 1.258667 3.804652l-7.813966 28.529777c1.983167 1.619894 4.094248 1.626034 6.335289 0.014326l18.472723-11.698436c1.042749-0.467651 1.939165-0.267083 2.681062 0.600681l10.658757 16.83134c0.382717 0.908696 0.093121 1.665942-0.862647 2.27174l-30.376844 19.237133c-3.421936 2.167363-7.261381 3.065825-11.522428 2.695389l-8.236592 0.615007c-1.218758 0.196475-2.312672 0.889253-3.28379 2.079358l-3.666506 6.92369c-2.173502 4.445242-5.585205 8.138354-10.235109 11.083429l-20.935822 13.258978c-1.917676 1.214664-2.998287 1.324158-3.242857 0.328481l-10.398838-16.420995c-0.51984-0.820692-0.369414-1.49198 0.451278-2.01182l12.725836-8.058536c1.914606-1.212618 2.836605-2.176572 2.764973-2.90005l1.573845-3.872191-20.004613-3.435239c-1.340531-0.300852-1.77339-0.984421-1.299599-2.052752l33.250288-21.057595c1.914606-1.212618 2.575662-2.588965 1.984191-4.13211l-0.218988-2.162246c-0.881067-0.780783-1.910513-0.896416-3.092431-0.341784l-40.229237 25.477254C755.182578 321.148277 754.202251 320.813656 753.472634 319.356468zM736.314859 292.26239l-9.618055-15.187911c-1.228991-1.329275-1.287319-2.636037-0.178055-3.913123l4.105504-2.600221c0.682545-0.432859 0.522909-1.288343-0.478907-2.572592l-9.358135-14.777565c-0.333598-1.128707 0.00307-2.110057 1.013073-2.942005l73.070202-46.273906c1.042749-0.467651 1.938142-0.267083 2.682086 0.601704l8.838296 13.956873c0.889253 2.312672 2.079358 3.28379 3.571339 2.914376l6.157233-3.89982c0.77055-0.294712 1.390673 0.081864 1.861394 1.122567l10.658757 16.830317c0.382717 0.908696 0.093121 1.665942-0.862647 2.27174l-16.009625 10.138918c-5.299703 3.743254-10.519588 3.980661-15.653515 0.712221l-8.852622-7.622608c-1.24127-0.74599-2.356674-0.9967-3.352351-0.753153l-20.935822 13.257955c-1.232061 0.779759-1.843998 1.936095-1.833765 3.461845l2.106987 7.868201c1.997494 6.78759 0.792039 12.149714-3.613294 16.090467l-19.294438 12.218276C739.021503 293.811676 737.679949 293.510824 736.314859 292.26239z"  ></path>'+""+'<path d="M309.49896 220.581838 305.907155 187.325409 334.488097 204.703195 365.007181 191.010335 357.311919 223.562728 379.766326 248.357438 346.428034 251.097852 329.786005 280.114722 316.878021 249.254877 284.139385 242.394632Z"  ></path>'+""+'<path d="M484.633722 158.276816 498.192529 127.69838 514.216481 157.060105 547.488259 160.506601 524.515035 184.819332 531.518542 217.528292 501.296217 203.191772 472.353025 219.960691 476.648864 186.78715 451.756941 164.442236Z"  ></path>'+""+'<path d="M835.590909 671.065785 855.145268 698.204889 821.709761 697.217399 801.941532 724.201983 792.548604 692.097798 760.77597 681.635515 788.406261 662.781098 788.538267 629.331265 815.008128 649.78204 846.861604 639.571491Z"  ></path>'+""+'<path d="M714.111161 811.766294 717.430766 845.051375 688.992063 827.440275 658.361439 840.883449 666.322761 808.394501 644.073014 783.417643 677.431773 780.949428 694.310186 752.069681 706.966437 783.033903 739.647767 790.162254Z"  ></path>'+""+'<path d="M538.471908 872.637664 524.663414 903.104559 508.880963 873.611851 475.637838 869.89418 498.809583 845.769736 492.073158 813.004495 522.17678 827.587632 551.257096 811.05612 546.69008 844.192821 571.398832 866.741373Z"  ></path>'+""+'<path d="M191.718463 356.99674 172.387185 329.699024 205.813482 330.958714 225.800699 304.136835 234.93166 336.316745 266.617313 347.038948 238.83455 365.66619 238.429321 399.113977 212.127282 378.447285 180.190919 388.397914Z"  ></path>'+""+'<path d="M287.799752 160.238494c128.089283-81.117482 283.980773-83.439364 410.487002-19.820418l30.555923-19.35072c-37.497009-20.921495-77.752852-36.281321-120.157637-45.803185-56.724932-12.736069-114.441449-14.390755-171.545004-4.91801-59.128679 9.80839-114.996081 31.175023-166.04985 63.507406-51.05377 32.331359-94.252641 73.702606-128.397299 122.962519-32.976042 47.573505-56.152904 100.456946-68.888973 157.181879-9.520841 42.404786-12.844539 85.36318-9.960863 128.204917l30.556946-19.35072C90.968851 381.291053 159.710468 241.355977 287.799752 160.238494z"  ></path>'+""+'<path d="M733.424019 863.906815c-128.089283 81.117482-283.980773 83.439364-410.487002 19.820418l-30.555923 19.35072c37.497009 20.921495 77.752852 36.282345 120.157637 45.803185 56.724932 12.736069 114.440425 14.390755 171.545004 4.91801 59.129702-9.80839 114.996081-31.176047 166.04985-63.507406 51.05377-32.331359 94.252641-73.701582 128.397299-122.962519 32.975019-47.573505 56.152904-100.456946 68.888973-157.181879 9.520841-42.403762 12.843516-85.362156 9.960863-128.204917l-30.555923 19.35072C930.255942 642.853234 861.514325 782.789333 733.424019 863.906815z"  ></path>'+""+'<path d="M380.266723 306.248939c35.836183-22.694885 75.393107-34.83539 115.010407-37.267788l47.251164-29.92352c-62.472843-7.42204-125.09202 6.686283-178.971138 40.806381-53.879118 34.121122-93.402273 84.699054-113.399723 144.347572l47.251164-29.92352C316.544423 359.514073 344.43054 328.943824 380.266723 306.248939z"  ></path>'+""+'<path d="M640.957047 717.895347c-35.836183 22.694885-75.394131 34.83539-115.01143 37.267788l-47.251164 29.92352c62.472843 7.42204 125.09202-6.686283 178.971138-40.806381 53.879118-34.121122 93.402273-84.699054 113.399723-144.348596l-47.251164 29.92352C704.680371 664.631236 676.794253 695.200462 640.957047 717.895347z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-fruits" viewBox="0 0 1078 1024">'+""+'<path d="M403.941053 237.675789C396.099368 238.753684 388.230737 239.319579 380.362105 239.319579 335.710316 239.319579 293.941895 222.073263 262.656 190.733474 225.576421 153.546105 208.491789 101.914947 215.821474 49.125053 217.492211 37.187368 226.842947 27.809684 238.753684 26.138947 290.923789 18.890105 343.228632 36.217263 380.011789 73.081263 417.118316 110.268632 434.202947 161.899789 426.846316 214.689684 425.202526 226.627368 415.851789 236.005053 403.941053 237.675789"  ></path>'+""+'<path d="M191.919158 273.488842C252.739368 256.781474 318.652632 270.794105 375.107368 311.915789 431.535158 270.794105 497.502316 256.727579 558.295579 273.488842 685.163789 308.547368 754.634105 466.836211 713.189053 626.364632 677.483789 763.715368 572.874105 859.648 458.725053 859.648 458.725053 859.648 458.725053 859.648 458.698105 859.648 441.209263 859.648 423.801263 857.276632 406.986105 852.641684 396.099368 849.623579 385.455158 845.635368 375.107368 840.704 364.759579 845.635368 354.088421 849.623579 343.228632 852.641684 326.413474 857.276632 309.005474 859.648 291.489684 859.648 177.367579 859.648 72.730947 763.715368 37.025684 626.364632-4.419368 466.836211 65.050947 308.547368 191.919158 273.488842"  ></path>'+""+'<path d="M978.189474 553.121684C954.206316 531.536842 941.002105 503.322947 941.002105 473.653895L941.002105 428.759579C941.002105 349.669053 885.733053 281.330526 812.355368 265.728 821.301895 248.373895 839.275789 236.382316 860.16 236.382316 875.061895 236.382316 887.107368 224.390737 887.107368 209.596632 887.107368 194.802526 875.061895 182.810947 860.16 182.810947 809.714526 182.810947 767.595789 217.546105 755.900632 264.111158 677.888 275.536842 617.660632 342.312421 617.633684 423.019789L617.633684 473.788632C617.633684 503.269053 604.725895 531.617684 582.170947 551.585684 519.841684 606.827789 483.651368 685.972211 482.923789 768.754526 481.845895 884.978526 570.071579 986.624 688.128 1005.217684 719.171368 1010.122105 749.864421 1012.601263 779.317895 1012.601263L779.344842 1012.601263C862.72 1012.601263 934.049684 992.956632 985.653895 955.823158 1044.587789 913.408 1075.738947 849.650526 1075.738947 771.422316 1075.738947 688.478316 1040.195368 608.929684 978.189474 553.121684"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-address2" viewBox="0 0 1036 1024">'+""+'<path d="M986.624764 243.679905l-94.386694-28.360931c-17.85567-100.541881-99.485829-167.57867-201.52276-167.57867-99.490945 0-181.121104 64.457034-201.526853 159.843498l-142.854569 41.251519c-5.097088 2.579755-10.199293 2.579755-12.751419 2.579755-5.102205 0-10.204409 0-15.308661-2.579755L68.286246 176.648232c-5.102205-2.577708-10.204409-2.577708-15.308661-2.577708-28.060079 0-51.017954 23.205515-51.017954 51.564399l0 608.435353c0 23.203468 15.303544 43.826158 35.716456 48.981574l280.597723 87.655386c5.104251 2.572592 10.206456 2.572592 15.308661 2.572592 5.104251 0 10.199293 0 12.751419-2.572592l329.073784-95.395674c5.102205-2.577708 10.206456-2.577708 12.756535-2.577708 5.104251 0 10.206456 0 15.303544 2.577708l249.992681 77.344552c5.104251 2.579755 10.206456 2.579755 15.308661 2.579755 28.062126 0 51.02-23.203468 51.02-51.561329L1019.789095 292.66148C1022.339174 269.459035 1007.030513 248.835322 986.624764 243.679905L986.624764 243.679905zM333.582471 305.555138l0 616.166431L52.977585 834.070276 52.977585 225.6339l252.544807 74.762751C315.728848 302.974359 323.379085 302.974359 333.582471 305.555138 333.582471 302.974359 333.582471 302.974359 333.582471 305.555138 333.582471 302.974359 333.582471 305.555138 333.582471 305.555138L333.582471 305.555138zM690.716334 99.302657c86.732363 0 153.053861 64.457034 153.053861 149.532665 0 33.516348-12.751419 69.607334-38.259372 105.70139-33.164331 46.403866-79.085196 116.016317-114.794489 170.155355-35.716456-51.559283-81.630159-123.751488-114.794489-170.155355-25.507954-36.094056-38.266535-72.185043-38.266535-105.70139C537.65531 163.759691 603.980901 99.302657 690.716334 99.302657L690.716334 99.302657zM971.32122 906.255319l-249.992681-77.342506-5.104251 0 0-5.155417L716.224288 669.069315c0-15.470343-10.204409-25.78834-25.507954-25.78834-15.308661 0-25.51 10.316973-25.51 25.78834l0 154.688081 0 5.155417-5.102205 0-275.502681 77.342506L384.601448 305.555138c0-5.157463-2.550079-7.737218-2.550079-12.892635l107.138112-30.93864c2.552126 46.413076 22.957875 85.077677 45.913703 121.175827 30.614252 43.824111 79.087243 116.01427 114.794489 167.573553 10.206456 15.46625 25.51 23.203468 43.370787 23.203468 17.853623 0 33.157167-7.737218 43.363623-23.203468 33.162284-51.559283 81.630159-123.749442 114.792443-167.573553 22.957875-33.520441 43.363623-72.194252 45.915749-116.018364l76.525907 23.201421 0 616.173594L971.32122 906.256342zM690.716334 331.333244c43.363623 0 76.527954-33.516348 76.527954-77.340459 0-43.829228-33.164331-77.344552-76.527954-77.344552-43.36874 0-76.525907 33.516348-76.525907 77.344552C614.190427 297.816896 647.347594 331.333244 690.716334 331.333244L690.716334 331.333244zM690.716334 228.207515c15.303544 0 25.507954 10.314926 25.507954 25.78527 0 15.46625-10.204409 25.781176-25.507954 25.781176-15.308661 0-25.51-10.314926-25.51-25.781176C665.205311 238.522442 675.407674 228.207515 690.716334 228.207515L690.716334 228.207515zM690.716334 228.207515"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-fruits1" viewBox="0 0 1024 1024">'+""+'<path d="M465.92 243.2c-2.56 0-2.56 0-5.12 0-12.8-2.56-23.04-15.36-20.48-30.72C476.16 15.36 634.88 0 637.44 0c15.36 0 25.6 10.24 28.16 23.04 0 12.8-10.24 25.6-23.04 28.16-5.12 0-122.88 12.8-151.04 171.52C488.96 235.52 476.16 243.2 465.92 243.2z"  ></path>'+""+'<path d="M279.04 51.2c64 0 97.28 28.16 97.28 38.4S343.04 128 279.04 128 184.32 99.84 184.32 89.6 217.6 51.2 279.04 51.2M279.04 0C197.12 0 133.12 40.96 133.12 89.6S197.12 179.2 279.04 179.2s148.48-40.96 148.48-89.6S360.96 0 279.04 0L279.04 0z"  ></path>'+""+'<path d="M463.36 1024C463.36 1024 463.36 1024 463.36 1024c-120.32 0-232.96-46.08-312.32-130.56-84.48-89.6-128-215.04-117.76-350.72 7.68-110.08 40.96-189.44 102.4-238.08 79.36-61.44 174.08-51.2 202.24-46.08 64 12.8 122.88 33.28 145.92 43.52 23.04-12.8 84.48-38.4 161.28-53.76 102.4-20.48 232.96 33.28 273.92 153.6 35.84 110.08 33.28 294.4-38.4 401.92C806.4 908.8 709.12 1024 463.36 1024zM289.28 302.08c-33.28 0-81.92 7.68-120.32 38.4-51.2 38.4-79.36 107.52-84.48 202.24C74.24 665.6 112.64 778.24 186.88 857.6c69.12 74.24 166.4 115.2 273.92 115.2 0 0 0 0 0 0 222.72 0 302.08-94.72 371.2-197.12 58.88-92.16 66.56-261.12 33.28-358.4-30.72-94.72-135.68-135.68-215.04-120.32-89.6 17.92-156.16 53.76-156.16 53.76-7.68 5.12-15.36 5.12-23.04 0 0 0-69.12-30.72-145.92-43.52C320 304.64 307.2 302.08 289.28 302.08z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-moren" viewBox="0 0 1024 1024">'+""+'<path d="M551.47506 81.639369l-18.947538-18.715247L522.258645 73.321936l12.20395 5.207605c-4.599761 11.4334-9.923 23.600511-15.965623 36.498262L551.47506 81.639369z"  ></path>'+""+'<path d="M513.1328 120.457466l-16.117073-6.79066c5.9055-10.601452 11.274788-20.967544 16.114003-31.102369l-30.127158 30.500665 18.947538 18.715247L513.1328 120.457466z"  ></path>'+""+'<path d="M581.602218 125.547391l5.815449 12.136412 10.270924-10.397814-18.947538-18.715247L545.876552 141.843542C558.853098 136.251174 570.762335 130.818441 581.602218 125.547391z"  ></path>'+""+'<path d="M539.371394 148.428517l-10.156314 10.282181 18.947538 18.715247 27.958772-28.304649c-10.305717 4.885264-20.574594 9.42772-30.80561 13.624299L539.371394 148.428517z"  ></path>'+""+'<path d="M594.750679 0.784876 0.777713 0.784876l1022.444575 1022.430248L1023.222287 429.268764 594.750679 0.784876zM832.084039 337.809749l42.971697 4.099365c0.520863 35.207873 0.452301 61.314461-0.205685 78.3126l-48.022737-4.067642C828.695872 396.699997 830.447772 370.5842 832.084039 337.809749zM313.959551 221.814921c18.023492-7.15598 36.793998-16.302291 56.32482-27.446096l12.32777 25.415856c-19.992333 10.380418-39.074947 19.376303-57.245795 26.992771L313.959551 221.814921zM356.970134 269.77626c10.626012-14.764262 20.47738-30.747281 29.559223-47.950082l22.128997 13.183254c-9.077749 17.816784-18.391882 34.177404-27.945469 49.087998L356.970134 269.77626zM395.495566 297.78722c8.465812-17.507746 15.936971-34.776038 22.415522-51.811016l23.260773 10.650571c-6.77224 19.484773-13.550621 36.979216-20.344351 52.487422L395.495566 297.78722zM568.304354 427.394067c-14.220886 2.689249-30.656207 6.387477-49.306986 11.097756-3.072989-38.795585 11.964496-82.978876 45.113477-132.558062-42.066071 31.185256-87.516216 46.852074-136.353504 47.000454 2.498914-16.705474 3.931542-32.789801 4.295839-48.254004 3.445472 0.208754 6.853082 0.3776 10.222829 0.511653 3.292999-12.114922 5.858428-24.341385 7.696286-36.677341l22.431895 6.407943c-38.252209-33.218566-75.072813-64.185858-110.461811-92.9029l22.784936-29.077246 50.693566 46.193065 12.895705-13.05534-43.209104-42.679032 21.453614-21.719674 43.209104 42.679032 11.639085-11.784394-40.666188-40.167838 90.606601-91.731214L639.949091 127.942951l-90.607624 91.731214-40.666188-40.167838-11.640108 11.784394 43.670615 43.134403-21.453614 21.719674-43.670615-43.134403-11.639085 11.784394 50.568722 44.470841c-9.145287 7.098675-17.291828 14.115486-24.444738 21.048385l-15.699564-13.681604c-0.945535 8.502651-2.495844 17.392112-4.659113 26.66736 36.102243-4.66116 75.55172-25.574469 118.344339-62.735833l-24.724101-24.420179 29.898961-30.269397 26.340925 26.018583c15.901155-15.484669 36.294624-35.81981 61.172221-61.005422l30.499641 30.125111c-26.779923 27.111474-47.246047 47.369867-61.402465 60.777225l46.211485 45.645596-29.897937 30.269397L623.750153 275.825023C583.200622 329.507666 564.720735 380.030339 568.304354 427.394067zM731.871663 212.348316c-4.010337 20.387329-8.714476 39.324634-14.118556 56.811914l-37.280068-12.170181c7.680936-20.715811 13.913894-39.815821 18.709107-57.299007L731.871663 212.348316zM656.393621 523.076266c11.630898-0.683569 21.478174-5.108345 29.54285-13.273305l76.227102-77.174684-23.567765-23.278169 29.670763-30.039153 54.298673 53.634548-81.705883 82.718957 51.453882 1.980097c-6.66991 11.063987-12.792351 23.581068-18.370393 37.546128-41.342594-0.356111-81.745792 1.728364-121.217782 6.258541L656.393621 523.076266zM947.46079 520.017604c-61.927421 75.019601-84.58649 143.406131-67.976184 205.155497-22.018479 4.421706-41.209564 8.597819-57.565067 12.527314-4.79112-56.772005 7.03216-106.870006 35.471886-150.297075-46.615691 25.473161-97.720625 36.617989-153.316851 33.440623 5.095042-17.792225 8.886391-36.111452 11.373025-54.956659 49.252751 4.824889 89.060385-0.933255 119.42802-17.270339 30.366611-16.341177 74.417897-54.198389 132.154879-113.575732l34.429137 34.006512C982.2839 487.996307 964.28292 504.986259 947.46079 520.017604z"  ></path>'+""+"</symbol>"+""+'<symbol id="icon-yixiajia" viewBox="0 0 1024 1024">'+""+'<path d="M343.516216 356.988554c51.241035-55.69344 123.537617-80.387865 193.285145-73.073273l25.576515-16.253172c-82.727143-16.727986-172.054611 9.048073-233.513358 75.846432-29.689183 32.268938-49.282427 70.233598-58.966997 109.986997l25.526374-16.21838c10.036587-28.916587 26.033933-56.314587 48.092321-80.288604z m92.589768-119.767758l20.385283-3.024893-10.940167-16.776082 4.461615-20.288068-19.847023 6.132674-17.628496-9.508561-1.320065 20.566407-15.35778 14.406105 19.026333 6.581906 8.142447 18.414395 13.077853-16.503883z m106.940614-37.107129l-20.511149 4.647857 13.027711 15.338336-2.330068 20.024056 19.615756-7.613398 19.073405 7.723915-0.904603-20.030195 14.119579-15.255449-20.178575-4.776794-10.346649-17.144472-11.565407 17.086144z m-294.761303 69.257363c112.654756-122.443703 290.324248-149.155065 430.646133-75.761497l19.306719-12.269442c-149.590993-84.138282-342.989725-57.627489-464.600457 74.54888-73.738421 80.146365-106.561991 183.359075-99.518575 283.877419l19.286252-12.252045c-3.671623-91.783403 27.662013-185.085392 94.879928-258.143315zM215.829092 412.489612l-19.587104 4.387937 12.467963 16.363689-2.197039 20.918426 18.72548-7.505951 18.225084 8.538467-0.895393-21.002337 13.459546-15.638165-19.279089-5.476735-9.905604-18.201547-11.013844 17.616216zM775.709589 754.629993c-112.64964 122.43654-290.318108 149.150972-430.641017 75.762521l-19.312858 12.265348c149.594063 84.142375 342.999958 57.626465 464.605573-74.54888 73.739445-80.144318 106.566084-183.361121 99.519598-283.878442l-19.285229 12.255115c3.674693 91.784426-27.66713 185.083345-94.886067 258.144338zM299.766806 279.926434l-19.971867-1.768273 6.887874 19.396769-8.445346 19.281135 20.10592-1.468444 14.748912 13.684674 5.528924-20.302395 17.564027-10.822487-16.682961-11.082406-3.89675-20.374026-15.838733 13.455453zM819.712779 598.914512l19.508309-4.319376-12.472056-16.268521 2.142803-20.766976-18.641569 7.421016-18.185174-8.515954 0.946558 20.859073-13.375635 15.501043 19.22076 5.474688 9.920954 18.096147 10.93505-17.48114z m-13.699-462.45663L47.56276 618.35119c-18.611893 11.83249-24.168446 36.482913-12.404517 55.067176l127.818107 201.893197c11.766998 18.578124 36.392862 24.055882 55.011918 12.228509l758.443855-481.893309c18.618033-11.830443 24.175609-36.483936 12.410658-55.063083L861.024673 148.693554c-11.769045-18.58631-36.397978-24.063045-55.010894-12.235672z m43.481303 31.355125L966.659549 352.875886c8.820899 13.939477 4.659113 32.42755-9.301854 41.299615L215.76974 865.361957c-13.96506 8.871041-32.43676 4.762467-41.258682-9.168824L57.340451 671.115927c-8.821923-13.931291-4.652973-32.42448 9.304923-41.294498l741.593072-471.183386c13.957897-8.875135 32.431643-4.762467 41.256636 9.174964z m-370.506428 656.983045l20.664645-3.118014-11.895934-16.170284 3.666506-19.703761-19.974937 6.118348-18.402116-9.061377-0.452301 19.952425-15.035438 14.105252 19.696598 6.212492 9.103332 17.777899 12.629645-16.11298z m134.915759-52.388161l-20.274766 2.952239 10.93198 16.717753-4.37668 20.155039 19.723203-6.03546 17.572214 9.506515 1.257644-20.448728 15.237029-14.289448-18.951631-6.599301-8.150634-18.335601-12.968359 16.376992z m114.671692-185.688119c-10.037611 28.918633-26.030863 56.316633-48.094368 80.295767-51.235918 55.689347-123.531478 80.383772-193.288214 73.068156l-25.574469 16.254196c82.727143 16.727986 172.051541-9.048073 233.509265-75.847456 29.694299-32.273031 49.293683-70.233598 58.977229-109.99109l-25.529443 16.220427z m13.443174 137.000234l19.883863 1.818415-6.915504-19.312858 8.352226-19.149129-20.001543 1.40193-14.715144-13.654998-5.439895 20.179598-17.449418 10.709923 16.630773 11.070126 3.937682 20.271696 15.71696-13.334703z"  ></path>'+""+'<path d="M391.976928 613.797477c14.001899-2.121314 25.858948-4.471848 35.568076-7.052626 6.482645 16.941857 11.202133 29.974685 14.156418 39.101553 2.955308 9.126868 2.266623 17.720593-2.062985 25.77913-4.330632 8.05956-12.228509 15.668865-23.695678 22.826891l-81.586157 50.93302c-26.820855 16.742313-48.992831 11.076266-66.516949-16.994046l-50.227962-80.45745 27.821649-17.3696 11.383258 18.234294 90.985224-56.800658-24.762986-39.665394-123.882472 77.338412-16.077164-25.75457 151.892409-94.824669 56.918338 91.173512-118.994138 74.28589 21.124109 33.837666c7.902994 12.657274 17.804505 15.269775 29.711696 7.836479l70.117964-43.773969c5.827729-3.637854 9.976212-7.486508 12.444427-11.556197 2.469238-4.065596 2.684132-8.706289 0.647752-13.923104-2.037403-5.212722-7.024997-16.272615-14.964829-33.174564zM512.818133 467.559858a2742.484148 2742.484148 0 0 1 89.37761 7.164167l-4.575202 35.772738c-32.807197-5.120624-62.050218-8.720615-87.73111-10.80202l65.131393 104.331183-30.453593 19.010983-91.773169-147.004075-69.178569 43.187615-16.546862-26.505678 181.593872-113.365953 16.546861 26.505677-81.96171 51.167356 23.353894 37.409005 6.216585-26.870998zM653.992433 428.803159c-3.903913-4.440126-10.133801-9.956769-18.689664-16.547884 0.916882 13.187347-0.977257 26.473955-5.68242 39.860846-7.358595-2.022053-16.330944-3.563152-26.918069-4.618181 7.795547-23.500227 6.858198-44.949748-2.808976-64.342423l-20.490683 12.791327-12.909008-20.677948 22.183232-13.848403c-2.879584-5.16872-6.118348-10.636245-9.717316-16.401552l22.747074-14.199397a395.087267 395.087267 0 0 1 9.717316 16.401552l40.416501-25.231661c23.040762 38.303374 35.022655 60.321854 35.947724 66.056462 0.924045 5.737678 0.466628 10.790764-1.376347 15.162328-1.841951 4.373611-12.649088 12.904914-32.419364 25.594934z m33.791617-23.708981l26.693966-16.664541 8.919137 14.287401 77.637218-48.467875 13.378705 21.430078-58.744939 36.674271c23.848151 3.748371 50.776454 1.478677 80.786954-6.806009a194.031135 194.031135 0 0 0 3.17839 31.455409c-35.099403 7.107885-67.663052 5.581112-97.695043-4.583388l30.981618 49.628304-26.693965 16.664541-30.864962-49.440016c-4.383844 28.688389-17.382902 58.224076-38.993083 88.610131-8.610098-5.423523-17.126053-9.860579-25.549909-13.309121 17.635659-22.24463 30.40345-45.801139 38.302351-70.675666l-55.924707 34.914185-13.378705-21.430079 76.886111-47.9992-8.919137-14.288425z m-65.144695-36.139082c7.461949 16.417925 11.639085 30.224372 12.534477 41.421389 7.465019-4.223185 13.513782-7.783267 18.151405-10.679224 3.821025-2.38635 5.39487-5.305843 4.720512-8.760524-0.675382-3.452635-6.5246-14.495132-17.547655-33.130562l-17.858739 11.148921z m38.038338-58.753125l72.375377-45.182039 47.059805 75.382875-72.375377 45.182038-47.059805-75.382874z m82.321913 25.15389L721.288119 300.5788l-23.498181 14.669094 21.711488 34.777061 23.49818-14.669094z"  ></path>'+""+"</symbol>"+""+"</svg>";var script=function(){var scripts=document.getElementsByTagName("script");return scripts[scripts.length-1]}();var shouldInjectCss=script.getAttribute("data-injectcss");var ready=function(fn){if(document.addEventListener){if(~["complete","loaded","interactive"].indexOf(document.readyState)){setTimeout(fn,0)}else{var loadFn=function(){document.removeEventListener("DOMContentLoaded",loadFn,false);fn()};document.addEventListener("DOMContentLoaded",loadFn,false)}}else if(document.attachEvent){IEContentLoaded(window,fn)}function IEContentLoaded(w,fn){var d=w.document,done=false,init=function(){if(!done){done=true;fn()}};var polling=function(){try{d.documentElement.doScroll("left")}catch(e){setTimeout(polling,50);return}init()};polling();d.onreadystatechange=function(){if(d.readyState=="complete"){d.onreadystatechange=null;init()}}}};var before=function(el,target){target.parentNode.insertBefore(el,target)};var prepend=function(el,target){if(target.firstChild){before(el,target.firstChild)}else{target.appendChild(el)}};function appendSvg(){var div,svg;div=document.createElement("div");div.innerHTML=svgSprite;svgSprite=null;svg=div.getElementsByTagName("svg")[0];if(svg){svg.setAttribute("aria-hidden","true");svg.style.position="absolute";svg.style.width=0;svg.style.height=0;svg.style.overflow="hidden";prepend(svg,document.body)}}if(shouldInjectCss&&!window.__iconfont__svg__cssinject__){window.__iconfont__svg__cssinject__=true;try{document.write("<style>.svgfont {display: inline-block;width: 1em;height: 1em;fill: currentColor;vertical-align: -0.1em;font-size:16px;}</style>")}catch(e){console&&console.log(e)}}ready(appendSvg)})(window)