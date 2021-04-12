
            <div class="card pub_image">
                <div class="card-header">

                    @if($image->user->image)
                    <div class="container-avatar">
                        <!-- haciendo que se imprima por pantalla el avatar en la configuracion -->
                        <img src="{{ route('user.avatar',['filename'=>$image->user->image]) }}" class="avatar" />
                        <!--se modifico aca-->
                        <!--esto lo sacamos de avatar.blade.php en includes-->
                    </div>
                    @endif
                    <div class="data-user">

                        <a href=" {{ route('profile', ['id' => $image->user->id]) }} ">
                            {{$image->user->name.' '.$image->user->surname }}
                            <!--para que se vea el nombre y la descripcion-->

                            <span class="nickname">
                                <!--para que se vea el nick -->

                                {{' | @'.$image->user->nick }}
                            </span>
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <div class="image-container">
                        <!--aqui mostraremos las imagenes como tal con el getmage del imagecontroller-->
                        <img src="{{ route('image.file',['filename' =>$image->image_path]) }}" />


                    </div>

                    <div class="description">
                        <!--div para la descripcion -->


                        <span class="nickname">{{'@'.$image->user->nick }}</span>
                        <span class="nickname date">{{ ' | '.\FormatTime::LongTimeFilter($image->created_at) }} </span>
                        <!--FECHA -->

                        <p>{{ $image->description }}</p>
                    </div>

                    <div class="likes">
                        <!--div para los likes -->

                        <!--COMPROBAR SI EL USUARIO DIO LIKE A LA IMAGEN-->
                        <?php $user_like = false; ?>
                        @foreach($image->likes as $like)
                            @if($like->user->id == Auth::user()->id)
                                <?php $user_like = true; ?>
                            @endif
                        @endforeach
                        
                        @if($user_like) <!--reflejando los likes-->
                        <img src="{{ asset('img/heartsazul.png') }}" data-id="{{ $image->id }}" class="btn-dislike" />
                        @else
                        <img src="{{ asset('img/heartsgris.png') }}" data-id="{{ $image->id }}" class="btn-like" />
                        @endif

                        <!--contador de los likes-->
                        <span class="number_likes">{{ count($image->likes) }}</span> 

                    </div>

                    <div class="comments">
                        <!-- botton de comentarios y numero de comentarios -->
                        <a href="{{ route('image.detail', ['id' => $image->id]) }}" class="btn btn-sm btn-warning btn-comments">

                            Comentarios( {{ count($image->comments)}} )
                        </a>

                    </div>

                </div>
            </div>