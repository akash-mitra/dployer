@extends('layouts.app')

@section('page.css')
    <style>
        .bg-smoke-light {
            background-color: rgba(0, 0, 0, 0.4);
        }
    </style>
    
@endsection

@section('content')
<div class="flex items-center">
    <div class="md:w-3/4 md:mx-auto">

        <div class="flex justify-between flex-wrap">
            <div class="font-serif text-2xl text-grey-darker  p-3">
                Platonic Creations
            </div>

            <div class="text-sm text-grey-darker p-3 self-end">
                    <button class="bg-teal hover:bg-blue-dark text-white font-bold py-2 px-4 rounded-full" id="btnCreateNew">
                        Create New
                    </button>
            </div>
        </div>
        

        <div class="rounded shadow">
            
            <div class="bg-white p-3 rounded-b">
                @if (session('status'))
                    <div class="bg-green-lightest border border-green-light text-green-dark text-sm px-4 py-3 rounded mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                
                <div id="blogList">
                    <table class="w-full text-grey-dark">
                        <thead class="w-full flex">
                            <tr class="w-full flex border-b-2">
                                <th class="py-2 w-1/6 text-left">Name</th>
                                <th class="py-2 w-1/3 text-left">Desc</th>
                                <th class="py-2 w-1/6 text-left">Public IP</th>
                                <th class="py-2 w-1/6 text-left">Created</th>
                                <th class="py-2 w-1/6 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="w-full flex flex-col">
                            @foreach($droplets as $droplet)

                                <tr class="flex w-full border-b">
                                    <td class="py-2 w-1/6">
                                        <a class="text-teal-dark no-underline show-modal" data-modal="{{$droplet->do_id}}" href="#">
                                            {{ $droplet->name }}
                                        </a>
                                    </td>
                                    <td class="py-2 w-1/3">{{ $droplet->desc }}</td>
                                    <td class="py-2 w-1/6" id="ip_{{ $droplet->do_id }}">{{ $droplet->public_ip ?? 'Getting IP...' }}</td>
                                    <td class="py-2 w-1/6">{{ $droplet->created_at->diffForHumans() }}</td>
                                    <td class="py-2 w-1/6" id="status_{{ $droplet->do_id }}">Checking ...</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>


<div id="dropletModalView" class="fixed pin z-50 overflow-auto bg-smoke-light flex" style="display: none">
    <div class="relative bg-white w-full max-w-lg h-full m-auto lg:h-auto lg:mx-auto lg:mt-4 lg:mb-4 flex-col flex border border-grey-dark shadow-lg">

        <div class="w-full p-2 bg-blue text-white p-8">
            <h2 id="blogName">The is my blog</h2>
            <p id="blogDesc">
                Some blog description
            </p>
            <span class="absolute pin-t pin-r my-4 mr-4 btnModalClose">
                <svg fill="rgba(0,50,50,0.2)" class="h-12 w-12 hover:text-white" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
                </svg>
            </span>
        </div>

        <div class="w-full p-2 bg-white p-8">
            <form class="w-full max-w-md">
                <!-- <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 mb-6">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-domain-name">
                            Domain Name
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border rounded py-3 px-4 mb-3" id="grid-domain-name" type="text" placeholder="example.me">
                        <button class="flex-no-shrink bg-teal hover:bg-teal-dark border-teal hover:border-teal-dark text-sm border-4 text-white py-1 px-2 rounded" type="button">
                            Sign Up
                        </button>
                        <p class="text-xs italic">Provide the domain name of your blog here.</p>
                    </div>


                    <div class="flex items-center border-b border-b-2 border-teal py-2">
                        <input class="appearance-none bg-transparent border-none w-full text-grey-darker mr-3 py-1 px-2" type="text" placeholder="Jane Doe" aria-label="Full name">
                        <button class="flex-no-shrink bg-teal hover:bg-teal-dark border-teal hover:border-teal-dark text-sm border-4 text-white py-1 px-2 rounded" type="button">
                            Sign Up
                        </button>
                        <button class="flex-no-shrink border-transparent border-4 text-teal hover:text-teal-darker text-sm py-1 px-2 rounded" type="button">
                            Cancel
                        </button>
                    </div>
                    <p class="text-xs mt-3 italic">Provide the domain name of your blog here.</p>

                </div> -->

                <div class="w-full px-3 mb-6">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-domain-name">
                        Domain Name
                    </label>
                    <small class="text-grey-dark">Associate a domain name with this Platonics blog. Make sure to point your nameservers to <code>ns1.digitalocean.com.</code> If you need further help, follow this guide.</small>
                    <div class="flex items-center border-b border-b-2 border-blue py-2">
                    
                        <input class="appearance-none bg-transparent border-none w-full text-grey-darker mr-3 py-1 px-2" type="text" placeholder="e.g. example.net" id="grid-domain-name" aria-label="Domain name">
                        <button id="btnSaveConfig" data-droplet="" class="flex-no-shrink bg-blue hover:bg-blue-dark border-blue hover:border-blue-dark text-sm border-4 text-white py-1 px-2 rounded" type="button">
                            Save
                        </button>
                    </div>
                </div>

                <div class="w-full px-3 my-8">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-domain-name">
                        Server Power
                    </label>
                    <small class="text-grey-dark">Get as much power as you need. We suggest starting with the smallest one though.</small>
                    <div class="mt-3 flex">
                        <div class="flex-1 text-grey-darker text-center bg-grey-lighter p-4 mr-2 border-2 border-green hover:border-green-lighter cursor-pointer rounded-lg">
                            <h4 class="text-green">TinkerBell</h4>
                            <small>Adorable</small>
                            <hr>
                            <small class="mt-2 text-grey-dark">1 GB Memory, 1 TB Transfer</small>
                        </div>
                        <div class="flex-1 text-grey-darker text-center bg-grey-lighter p-4  border-2 rounded-lg">
                            <h4>Jasmine</h4>
                            <small>Adventurous</small>
                            <hr>
                            <small class="mt-2 text-grey-dark">2 GB Memory, 3 TB Transfer</small>

                        </div>
                        <div class="flex-1 text-grey-darker text-center bg-grey-lighter p-4 ml-2 border-2 rounded-lg">
                            <h4>Pocahontas</h4>
                            <small>Powerful</small>
                            <hr>
                            <small class="mt-2 text-grey-dark">4 GB Memory, 4 TB Transfer</small>
                        </div>
                    </div>
                </div>


            </form>
        </div>

        <div class="w-full absolute pin-b border bg-blue-lightest p-4">
            
            <button class="btn bg-blue text-white hover:bg-blue-dark border-blue hover:border-blue-dark px-4 py-2 rounded btnModalClose">Done</button>
        </div>

    </div>
</div>
@endsection

@section('page.script')
<script>

    var gDroplets = {!! json_encode($droplets) !!};
    
    var getDropletInfo = function (doId) {
        let l = gDroplets.length;
        for (var i = 0; i < l; i++) {
            let droplet = gDroplets[i];
            if (droplet.do_id === doId) return droplet;
        }
        return {}
    }


    var populateModalFor = function (doId) {
        
        var droplet = getDropletInfo(doId);

        $('#blogName').text (droplet.name);
        $('#blogDesc').text (droplet.desc);
        $('#btnSaveConfig').data('droplet', droplet.do_id);

        $('#dropletModalView').fadeIn();
    }


    let saveDropletConfig = function () 
    {
        let data = {
            "domain": $('#grid-domain-name').val(),
            "do_Id": $('#btnSaveConfig').data('droplet'),
            "_token": '{{ csrf_token() }}'
        }

        let request = $.ajax ({
            "url": '{{ route("droplet-update-domain") }}',
            "method": 'post',
            "data": data,
            "success":function (reply) {
                console.log(reply)
            }
        });

        
    }


    let retrieveIPAddresses = function () {

        for(let i = 0; i < gDroplets.length; i++)
        {
            let droplet = gDroplets[i];

            let url = '/api/droplets/' + droplet.do_id + '/ip';

            $.ajax ({
                "url": url,
                "method": "get",
                "success": function (ip) {
                    $('#ip_' + droplet.do_id).text (ip);
                },
                "error": function (ip) {
                    if (ip.responseJSON.message === 'The resource you were accessing could not be found.')
                        $('#ip_' + droplet.do_id).text ('Not Found');
                    else 
                        $('#ip_' + droplet.do_id).text ('error');
                }
            });
        }
    }

    let determineDropletStatus = function () {

        for(let i = 0; i < gDroplets.length; i++)
        {
            let droplet = gDroplets[i];

            let url = '/api/droplets/' + droplet.do_id + '/status';

            $.ajax ({
                "url": url,
                "method": "get",
                "success": function (status) {
                    $('#status_' + droplet.do_id).text (status);
                },
                "error": function (status) {
                    $('#status_' + droplet.do_id).text ('error');
                }
            });
        }
    }


    $(document).ready(function () {

        $('#btnCreateNew').click(function () {
            location.href="{{ route('blog-create') }}";
        });

        $('a.show-modal').click (function () {
            var doId = $(this).data('modal');
            populateModalFor (doId);
        })

        $('.btnModalClose').click (function () {
            $('#dropletModalView').fadeOut();
        })

        $('#btnSaveConfig').click (saveDropletConfig);

        retrieveIPAddresses();
        determineDropletStatus();
    });
</script>
@endsection
