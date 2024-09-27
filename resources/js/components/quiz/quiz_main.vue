<template>
    <div id="quiz">
        <div class="modal fade bd-example-modal-lg" id="questionInfo" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ trans('quiz.Question')}} {{ questionNavigation.checkLangType }}</h5>
                        <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-0">
                        <div >
                            <ckeditor :config="editorConfig" v-model="questionInfo"></ckeditor>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="saveInfo()" :disabled="loading">
                            <span v-if="loading" class="spinner-border spinner-border-sm mr-1"  style="padding: 5px;" role="status" aria-hidden="true"></span>

                            {{trans('quiz.Save')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid mt-4">
            <div class="row">
                <div class="col-xl-10 col-md-12">

                    <div class="kt-portlet">

                        <div class="kt-portlet__body " id="kt-portlet__body">
                            <div class="d-sm-flex justify-content-between" v-if="quiz_id">
                                <div >
                                    All questions required?  
                                    <span class="mr-2"><input type="radio" :checked="is_required_fields" name="isRequiredFields"  @change="isRequiredFields(true)"> Yes</span>
                                    <span><input type="radio" name="isRequiredFields" :checked="is_required_fields ? false : true" @change="isRequiredFields(false)"> No</span>
                                </div>

                                <div class="material-switch mb-3 d-flex align-items-center justify-content-sm-end mt-sm-0 mt-3" >
                                    <span class="mr-3 mb-1">
                                        {{ trans('quiz.is_quiz_active') }}
                                    </span>
                                    <input id="someSwitchOptionSuccess" name="someSwitchOption001" type="checkbox" @change="quizActive" v-model="quiz_is_active"/>
                                    <label for="someSwitchOptionSuccess" class="label-success"></label>
                                </div>
                            </div>

                            <div class="timeline timeline-5 mt-3">
                                <div v-if="!quizHide" class="d-flex block-1 align-items-center mb-4">
                                    <p class="m-0">{{title}}</p>
                                    <a href="#" @click.prevent="quizEdit"
                                       class="btn btn-sm btn-clean btn-icon btn-icon-md ml-auto"
                                       title="Edit details">
                                        <i class="flaticon-edit"></i>
                                    </a>
                                </div>
                                <form action="" v-if="quizHide" class="quizCreateForm"
                                      @submit.prevent="createQuiz($event)">
                                    <div class="form-group">
                                        <label for="Title">{{ trans('quiz.Title') }}</label>
                                        <input type="text" class="form-control title" maxlength="255"
                                               :placeholder="trans('quiz.Title')"
                                               v-model.trim="title"
                                               id="Title">
                                        <div class="valid mt-2 error" v-if="quiz_create_valid.title">
                                            {{ trans('quiz.The field is required.') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Description">{{ trans('quiz.Description') }}</label>
                                        <textarea class="form-control description"
                                                  :placeholder="trans('quiz.Description')"
                                                  v-model.trim="description"
                                                  id="Description"></textarea>
                                        <div class="valid mt-2 error" v-if="quiz_create_valid.description">
                                            {{ trans('quiz.The field is required.') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="minute">
                                            Workshop Date
                                        </label>
                                       <!-- <input type="number" class="form-control"
                                               :placeholder="trans('quiz.Enter the Duration in Minutes')"
                                               v-model="time_limit"
                                               id="minute" min="0" max="9999"
                                               onkeydown="return ((event.keyCode>7) && (event.keyCode<56) || (event.keyCode >= 96) && (event.keyCode<=105) );">-->
<!--                                        <input type="text" v-model="time_limit" autocomplete="off" id="minute" class="form-control datepicker w-100">-->
<!--                                        <datepicker v-model="time_limit" input-class="form-control" format="d.M.yyyy" :language="en" :use-utc="true"></datepicker>-->
                                        <br>

                                        <datetime  v-model="time_limit" :min-datetime="current_date" input-class="form-control w-100" format="dd MMM y"  type="date"></datetime>
                                        <!--                                        <input type="date" pattern="mm/dd/yyyy" autocomplete="off" v-model="time_limit" id="minute"  class="form-control  w-100">-->
                                        <div class="valid mt-2 error" v-if="quiz_create_valid.limit_time" v-for="error in quiz_create_valid.limit_time">
                                            {{ trans(error) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <multiselect v-model="groups" :options="groups_options" placeholder="Select groups"  @input="onChangeGroups" label="name" track-by="name" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true"></multiselect>
                                    </div>
                                    <div class="form-group">
                                        <multiselect v-model="company" :options="companies_options" placeholder="Select company"  @input="onChangeCompanies" label="name" track-by="name" :multiple="false" :close-on-select="true" :clear-on-select="false" :preserve-search="true"></multiselect>
                                    </div>
                                    <br>
                                    <div class="text-right">
                                        <button type="submit" :disabled="loading" class="btn btn-primary" v-if="saveOrEdit"
                                                id="object-form-confirm">
                                            <span v-if="loading" class="spinner-border spinner-border-sm mr-1" style="padding: 5px;" role="status" aria-hidden="true"></span>
                                            {{ trans('quiz.Save') }}
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="openQuestion" class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-xl-10 col-md-12">
                    <div class="kt-portlet">
                        <div class="kt-portlet__body">
                            <div class="timeline timeline-5 mt-3">

                                <app-question v-for="(item, index) in questionData" :index="index"
                                              :quizResponse="quizResponse" :quiz_id="quiz_id" :item="item" :key="index"
                                              @allQuestions="allQuestions" @questionCountDelete="questionCountDelete"/>
                                <div class="text-center">
                                    <a href="#" class="btn btn-success btn-success-2 add__question__item"
                                       @click.prevent="addNewQuestion"><span class="plus-icon2 mr-2"><span
                                        class="plus-vertical-correction">+</span></span>
                                        {{ trans('quiz.Create New Question') }}

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="openQuestion" class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-xl-10 col-md-12">
                    <div class="kt-portlet">
                        <div class="kt-portlet__body">
                            <div class="timeline timeline-5 mt-3 ">
                                <div class="modal fade" id="exampleModalCenter2" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ trans('quiz.Question')}} {{ questionNavigation.checkLangType }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group" v-show="questionNavigation.file_type.url">
                                                    <label for="url"><b>{{ trans(`quiz.${questionNavigation.file_type.name} link address`) }}</b></label>
                                                    <input type="text" class="form-control" id="url"
                                                           @input="questionNavigationUrlChange"
                                                           v-model="questionNavigation.url"
                                                           :class="{'is-invalid': error.validUrl}" :placeholder="question_file_type">
                                                    <div v-if="error.validUrl" class="mt-1" style="color: red">
                                                        {{trans('quiz.Please enter correct values')}}
                                                    </div>
                                                    <div v-if="error.validUrlYoutube" class="mt-1" style="color: red">
                                                        {{trans('quiz.Please enter correct Youtube video url')}}
                                                    </div>
                                                </div>
                                                <div class="form-group  align-items-center" :class="{'d-md-flex' : questionNavigation.class}" v-show="questionNavigation.file_type.file">
                                                    <div v-show="questionNavigation.class"
                                                         class="position-relative question-img-preview "
                                                         :class="{'my-style block-5': questionNavigation.class}">
                                                        <img :src="questionNavigation.file_url" alt="">
                                                    </div>

                                                    <div class="block-3 d-flex align-items-center ">
                                                        <div class="custom-file w-auto">
                                                            <input type="file" class="custom-file-input " id="file"
                                                                   @change="getFileQuestion($event)">
                                                            <label class="custom-file-label overflow-hidden" for="file">
                                                                {{ trans('quiz.Choose file')}}</label>
                                                        </div>
                                                    </div>

                                                    <div class="position-relative question-video-preview "
                                                         style="margin-bottom: -25px;" v-show="questionNavigation.video">
                                                        <video :src="questionNavigation.file_url" width="100%"
                                                               height="100%" class="mt-3" controls></video>
                                                    </div>
                                                </div>
                                                <div v-if="error.validUploadFile" class="mt-1" style="color: red">
                                                    {{trans('quiz.Please select')}} {{ questionNavigation.checkLangType__}}
                                                </div>
                                            </div>
                                            <div class="modal-footer">

                                                <button v-if="formChanged" type="button" class=" btn btn-secondary"
                                                        @click="questionNavigationFileTypeChange(trans('quiz.Choose file'))">
                                                    {{trans('quiz.Clear')}}
                                                </button>
                                                <button type="button" class="btn btn-primary" v-if="modal_button_save" data-dismiss="modal">
                                                    {{trans('quiz.Save')}}
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <draggable
                                    tag="div"
                                    v-model="dataQuestions"
                                    v-bind="dragOptions"
                                    @change="changeQuestions"
                                >
                                    <div class="accordion accordion-quize" :id="'accordionExample'+element.id"
                                         v-for="(element, index) in dataQuestions"
                                         :key="element.id">
                                        <div class="card mb-3">
                                            <div class="card-header question" :id="'headingOne'+element.id">
                                                <div class="card-title">
                                                    <span @click="openedItem(element.id)" class="collapsed quiz-question-title-ellipsis mr-2"
                                                          data-toggle="collapse"
                                                          :data-target="'#collapseOne'+element.id"
                                                          :aria-expanded="index ? 'false' : 'true'"
                                                          :aria-controls="'collapseOne'+element.id">
                                                        <img src="/img/Image 382.png" alt="" class="mr-3 my-handle">

                                                        <svg v-if="element.file_type == 'image' || element.file_type == 'image_url'" class="bi bi-card-image "
                                                             width="1.4em" height="1.4em"
                                                             viewBox="0 0 16 16"
                                                             fill="#5867dd"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                                                <path fill-rule="evenodd"
                                                                                      d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                                                                <path
                                                                                    d="M10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/>
                                                                                <path fill-rule="evenodd"
                                                                                      d="M4.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                                                            </svg>
                                                        <svg v-if="element.file_type == 'video' || element.file_type == 'youtube'" class="bi bi-camera-video-fill "
                                                             width="1.4em" height="1.4em"
                                                             viewBox="0 0 16 16"
                                                             fill="#5867dd"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M2.667 3h6.666C10.253 3 11 3.746 11 4.667v6.666c0 .92-.746 1.667-1.667 1.667H2.667C1.747 13 1 12.254 1 11.333V4.667C1 3.747 1.746 3 2.667 3z"/>
                                                                                <path
                                                                                    d="M7.404 8.697l6.363 3.692c.54.313 1.233-.066 1.233-.697V4.308c0-.63-.693-1.01-1.233-.696L7.404 7.304a.802.802 0 0 0 0 1.393z"/>
                                                                            </svg>
                                                        {{element.title}}

                                                    </span>

                                                    <div class="ml-auto text-nowrap " >
                                                        <a href="#" @click.prevent="setQuestionInfo(element)" data-target="#questionInfo" data-toggle="modal" class="btn btn-sm  btn-clean btn-icon btn-icon-md ml-auto ml-2">
                                                            <i class="far fa-question-circle"></i>

                                                        </a>
                                                        <a href="#"
                                                           @click.prevent="questionEdit(element, [
                                                               trans('quiz.Multiple'),
                                                               trans('quiz.Yes/No'),
                                                               trans('quiz.Dropdown'),
                                                               trans('quiz.Short Text'),
                                                               trans('quiz.Picture Choice'),
                                                               trans('quiz.Long Text'),
                                                               'Circling',
                                                           ], trans('quiz.Choose file'))"
                                                           class="btn btn-sm  btn-clean btn-icon btn-icon-md ml-auto"
                                                           :title="trans('quiz.Edit details')">
                                                            <i class="flaticon-edit"></i>
                                                        </a>
                                                        <a href="#" @click.prevent="cloneQuestion(element.id)"
                                                           class="btn btn-sm btn-clean btn-icon btn-icon-md ml-auto"
                                                           :title="trans('quiz.Copy')">
                                                            <img src="/img/copy.svg" alt="">
                                                        </a>
                                                        <a href="#" @click.prevent="questionDelete(element.id, index)"
                                                           class="btn btn-sm btn-clean btn-icon btn-icon-md"
                                                           :title="trans('quiz.Delete')">
                                                            <i class="flaticon2-trash"></i>
                                                        </a>
                                                        <img style="padding: 12px 10px;transition: .2s"  @click="openedItem(element.id)" :class="[opened === element.id ? 'rotate' : '']" src="/img/directional.svg" alt="" data-toggle="collapse"
                                                             :data-target="'#collapseOne'+element.id">
                                                    </div>
                                                </div>
                                            </div>

                                            <div :id="'collapseOne'+element.id" :data-id="element.id"
                                                 class="questionBodyCollapse collapse"
                                                 :aria-labelledby="'headingOne'+element.id"
                                                 :data-parent="'#accordionExample'+element.id"
                                                 :data-question-id="element.id">
                                                <div class="card-body questionItemEdit">
                                                    <div class="edit-block">
                                                        <div class="d-md-flex align-items-end block-2 mb-5">
                                                            <div class="form-group mb-0 questionTitleAndNavigationBlock w-100"
                                                                 @mouseover="showEditNavigation()" @mouseout="hide">
                                                                <div class="d-flex justify-content-end">
                                                                    <div class="questionsNavigationButton" :class="{'_show':showNavigation}"
                                                                         data-toggle="modal"
                                                                         data-target="#exampleModalCenter2">
                                                                        <button :class="{'active' : questionNavigation.file_type.name == 'image'}" class="q-navigation-btn" style="margin-right: -4px;"
                                                                            @click.prevent="questionNavigationControl('image', trans('quiz.image'), trans('quiz.Choose file'), 'jpeg | jpg | gif | png', trans('quiz.image__'))">
                                                                            <svg class="bi bi-card-image "
                                                                                 width="1.4em" height="1.4em"
                                                                                 viewBox="0 0 16 16"
                                                                                 fill="currentColor"
                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                <path fill-rule="evenodd"
                                                                                      d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                                                                <path
                                                                                    d="M10.648 7.646a.5.5 0 0 1 .577-.093L15.002 9.5V13h-14v-1l2.646-2.354a.5.5 0 0 1 .63-.062l2.66 1.773 3.71-3.71z"/>
                                                                                <path fill-rule="evenodd"
                                                                                      d="M4.502 7a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                                                            </svg>
                                                                        </button>
                                                                        <button :class="{'active' : questionNavigation.file_type.name == 'video'}" class="q-navigation-btn"
                                                                            @click.prevent="questionNavigationControl('video', trans('quiz.video'), trans('quiz.Choose file'),  trans('quiz.Youtube video url'), trans('quiz.video__'))">
                                                                            <svg class="bi bi-camera-video-fill "
                                                                                 width="1.4em" height="1.4em"
                                                                                 viewBox="0 0 16 16"
                                                                                 fill="currentColor"
                                                                                 xmlns="http://www.w3.org/2000/svg">
                                                                                <path
                                                                                    d="M2.667 3h6.666C10.253 3 11 3.746 11 4.667v6.666c0 .92-.746 1.667-1.667 1.667H2.667C1.747 13 1 12.254 1 11.333V4.667C1 3.747 1.746 3 2.667 3z"/>
                                                                                <path
                                                                                    d="M7.404 8.697l6.363 3.692c.54.313 1.233-.066 1.233-.697V4.308c0-.63-.693-1.01-1.233-.696L7.404 7.304a.802.802 0 0 0 0 1.393z"/>
                                                                            </svg>
                                                                        </button>
                                                                    </div>

                                                                </div>

                                                                <input type="text"
                                                                       @input="questionNameChange"
                                                                       class="form-control questionName"
                                                                       :placeholder="trans('quiz.Enter your question')"
                                                                       v-model.trim="questionName">
                                                                <div class="valid q-correct mt-2 position-absolute"
                                                                     v-show="valid_error.r_title">
                                                                    {{ trans('quiz.Is required question title') }}
                                                                </div>
                                                                <div class="valid q-correct mt-2 position-absolute"
                                                                     v-show="valid_error.r_select">
                                                                    {{ trans('quiz.Please select question type') }}
                                                                </div>
                                                                <div class="valid q-correct mt-2 position-absolute" v-show="valid_error.r_limit">
                                                                    {{trans('quiz.This field must not exceed 255 characters')}}
                                                                </div>

                                                            </div>
                                                            <div class="dropdown">

                                                                <button
                                                                    class="btn btn-secondary dropdown-toggle w-100"
                                                                    type="button"
                                                                    :id="'dropdownMenuButton'+element.id"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    {{ questionCurrentType || trans('quiz.Select question type') }}
                                                                </button>
                                                                <div class="dropdown-menu w-100"
                                                                     :aria-labelledby="'dropdownMenuButton'+element.id">
                                                                    <table class="table drop-table">
                                                                        <tr>
                                                                            <td @click="selectQuestionType('multiple', element.id, trans('quiz.Multiple'))">
                                                                                <img src="/img/Multiple.svg" alt="">{{trans('quiz.Multiple')}}
                                                                            </td>
                                                                            <td @click="selectQuestionType('radio', element.id, trans('quiz.Yes/No'))">
                                                                                <img
                                                                                    src="/img/radio.svg" alt="">{{trans('quiz.Yes/No')}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td @click="selectQuestionType('dropdown', element.id,  trans('quiz.Dropdown'))">
                                                                                <img src="/img/Dropdown.svg" alt="">{{trans('quiz.Dropdown')}}
                                                                            </td>
                                                                            <td @click="selectQuestionType('text', element.id, trans('quiz.Short Text'))"><span
                                                                                class="short-text-icon"></span>{{trans('quiz.Short Text')}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td @click="selectQuestionType('file', element.id, trans('quiz.Picture Choice'))">
                                                                                <img
                                                                                    src="/img/photo2.svg" alt="">{{
                                                                                trans('quiz.Picture Choice') }}
                                                                            </td>
                                                                            <td @click="selectQuestionType('textarea', element.id, trans('quiz.Long Text'))">
                                                                                <span class="long-text-icon"></span>{{trans('quiz.Long Text')}}
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td @click="selectQuestionType('circling', element.id, 'Circling')">
                                                                                <span class="select"> <i class="far fa-check-circle"></i></span>Circling
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-if="questionType === 'multiple'" v-for="(item, index) in data"
                                                             class="block-3 d-flex align-items-center mb-3 ">
                                                            <div class="form-group mb-0 position-relative answer flex-grow-1 d-flex align-items-center overflow-hidden">
                                                                <button @click.prevent="deleteAnswer(index)" class="answer-delete-btn">X</button>
                                                                <input type="text" class="form-control" :placeholder="trans('quiz.Enter an answer choice')"
                                                                       v-model.trim="data[index]['title']">
                                                                <div class="position-absolute correct-answer checkbox checkbox-outline checkbox-outline-2x checkbox-success ">
                                                                    <span class="CP">{{trans('quiz.Correct answer')}}</span>
                                                                    <span class="mobile position-absolute">
                                                                        {{trans('quiz.Correct answer')}}
                                                                    </span>
                                                                    <input type="checkbox" @change="showMessageSelectCorrectAnswer($event)" v-model="data[index]['is_right']">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div v-if="questionType === 'circling'" v-for="(item, index) in data"
                                                             class="block-3 d-flex align-items-center mb-3 ">
                                                            <div class="form-group mb-0 position-relative answer flex-grow-1 d-flex align-items-center overflow-hidden">
                                                                <button @click.prevent="deleteAnswer(index)" class="answer-delete-btn">X</button>
                                                                <input type="text" class="form-control" :placeholder="trans('quiz.Enter an answer choice')"
                                                                       v-model.trim="data[index]['title']">
                                                                <div class="position-absolute correct-answer checkbox checkbox-outline checkbox-outline-2x checkbox-success ">
                                                                    <span class="CP">{{trans('quiz.Correct answer')}}</span>
                                                                    <span class="mobile position-absolute">
                                                                        {{trans('quiz.Correct answer')}}
                                                                    </span>
                                                                    <input type="checkbox" @change="showMessageSelectCorrectAnswer($event)" v-model="data[index]['is_right']">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div v-if="questionType === 'radio'"
                                                             class="block-3  mb-3 ">
                                                            <div class="d-flex align-items-center mb-3 answer">
                                                                <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-success mr-1 mb-0">
                                                                    <span class="d-flex align-items-center " style="width: 30px;">
                                                                        {{ trans('quiz.Yes')}}
                                                                    </span>
                                                                </label>

                                                                <div class="form-group mb-0 position-relative flex-grow-1 ml-3">
                                                                    <div class="correct-answer checkbox checkbox-outline checkbox-outline-2x checkbox-success justify-content-start" style="background: transparent;">
                                                                        <span class="mr-3">{{trans('quiz.Correct answer')}}</span>
                                                                        <input type="radio" name="Yes/No" :value="true" @change="getRadioValue(true, 'Yes')">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-success mr-1 mb-0">
                                                                    <span class="d-flex align-items-center " style="width: 30px;">
                                                                        {{ trans('quiz.No')}} 
                                                                    </span>
                                                                </label>
                                                                <div class="form-group mb-0 position-relative flex-grow-1 ml-3">
                                                                    <div class="correct-answer checkbox checkbox-outline checkbox-outline-2x checkbox-success justify-content-start" style="background: transparent;">
                                                                        <span class="mr-3">{{trans('quiz.Correct answer')}}</span>
                                                                        <input type="radio" name="Yes/No" :value="false" @change="getRadioValue(false, 'No')">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div v-if="questionType === 'file'"
                                                             class="block-3 d-md-flex align-items-center mb-3 image-block"
                                                             v-for="(item, index) in data">
                                                            <div class="position-relative mb-3 block-5 ">
                                                                <button type="button" style="display: block"
                                                                        class="position-absolute userSelectImageIcon"
                                                                        @click="clearUserSelectImg(index, trans('quiz.Choose file'))">
                                                                    ×
                                                                </button>
                                                                <div class="img-preview block-5 mr-0">
                                                                    <img class="rounded" :src="data[index]['file_url'] ? data[index]['file_url'] : data[index]['url']"
                                                                         alt="">
                                                                </div>
                                                            </div>
                                                            <div class="block-3 d-flex align-items-center mb-3 position-relative answer">
                                                                <div class="custom-file w-auto ">
                                                                    <input type="file" class="custom-file-input answer-image"
                                                                           id="customFile" @change="getImages(index, $event)">
                                                                    <label class="custom-file-label answer-image-label" for="customFile">{{trans('quiz.Choose file')}}</label>
                                                                </div>
                                                                <div class="correct-answer checkbox checkbox-outline checkbox-outline-2x checkbox-success " style="background: transparent;">
                                                                    <span class="CP">{{trans('quiz.Correct answer')}}</span>
                                                                    <span class="mobile position-absolute"  style="top: -14px; width: auto">
                                                                        {{trans('quiz.Correct answer')}}
                                                                    </span>
                                                                    <input type="checkbox" @change="showMessageSelectCorrectAnswer($event)" v-model="data[index]['is_right']">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-if="questionType === 'dropdown'" v-for="(item, index) in data"
                                                             class="block-3 d-flex align-items-center mb-3">
                                                            <div class="form-group mb-0 position-relative answer flex-grow-1 d-flex align-items-center overflow-hidden">
                                                                <button @click.prevent="deleteAnswer(index)" class="answer-delete-btn">X</button>
                                                                <input type="text" class="form-control pr-5" :placeholder="trans('quiz.Enter an answer choice')"
                                                                       v-model.trim="data[index]['title']" >
                                                                <div class="position-absolute correct-answer checkbox checkbox-outline checkbox-outline-2x checkbox-success ">
                                                                    <span class="CP">{{trans('quiz.Correct answer')}}</span>
                                                                    <span class="mobile position-absolute">
                                                                        {{trans('quiz.Correct answer')}}
                                                                    </span>
                                                                    <input type="checkbox" @change="showMessageSelectCorrectAnswer($event)" v-model="data[index]['is_right']">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-if="validationAnswerNoVariants" style="color: red">
                                                            {{trans('quiz.To save the question you need to create at least one option')}}
                                                        </div>
                                                        <div v-if="validationAnswer" style="color: red">
                                                            {{trans('quiz.Please fill in all fields and select at least one correct variant')}}
                                                        </div>
                                                        <div v-if="validationAnswerUploadFile" style="color: red">
                                                            {{trans('quiz.Please select')}} {{trans('quiz.image__')}}
                                                        </div>
                                                        <div v-if="addOtherQuestionShow"
                                                             class="block-4 d-inline-flex align-items-center mt-3 mb-3"
                                                             @click="addOtherQuestion()">
                                                            <span class="plus-icon mr-2">+</span>
                                                            <p class="m-0">{{trans('quiz.Add new answer')}}</p>
                                                        </div>
                                                        <div class="text-right d-flex justify-content-between align-items-end">
                                                            <div class="d-flex align-items-center">
<!--                                                                <input type="checkbox" v-model="is_priority"/> <span class="ml-2"> {{ trans('quiz.test') }}</span>-->
                                                            </div>
                                                            <div>
                                                                <div>
                                                                    <label for="question_required">Question Required  </label>
                                                                    <input type="checkbox" id="question_required" v-model="question_required">
                                                                </div>
                                                                <a href="#" class="btn btn-secondary mr-2"
                                                                   @click.prevent="formToEmpty">{{trans('quiz.Clear')}}</a>
                                                                <button type="submit" class="btn btn-primary" :disabled="loading"
                                                                        @click="questionUpdateSave(element.id)">
                                                                    <span v-if="loading" class="spinner-border spinner-border-sm mr-1" style="padding: 5px;" role="status" aria-hidden="true"></span>
                                                                    <span>{{trans('quiz.Save')}}</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="preview">
                                                        <div v-if="element.type === 'multiple'">
                                                            <div class="d-flex align-items-center mb-4"
                                                                 v-for="answer in element.answers">
                                                                <label
                                                                    class="radio radio-outline radio-big radio-success mr-4 mb-0 d-flex align-items-center">
                                                                    <input type="checkbox" class="mr-2">
                                                                    {{answer.title}}
                                                                    <span></span>
                                                                </label>
                                                                <img v-if="answer.is_right" src="/img/correct.svg"
                                                                     alt="" class="">
                                                            </div>
                                                        </div>
                                                        <div v-if="element.type === 'radio'">
                                                            <div v-for="answer in element.answers" :key="answer.id">
                                                                <div class="d-flex align-items-center mb-3">
                                                                    <label
                                                                        class="checkbox checkbox-outline checkbox-outline-2x checkbox-success mb-0">
                                                                        <span class="d-flex align-items-center "
                                                                              style="width: 60px;">
                                                                            <input
                                                                                class="d-flex align-items-center mr-1"
                                                                                type="radio" name="type-radio[2]"
                                                                                :value="true"> 
                                                                            {{trans('quiz.'+answer.title)}}
                                                                        </span>
                                                                    </label>
                                                                    <div
                                                                        class="form-group mb-0 position-relative flex-grow-1 ">
                                                                        <img src="/img/correct.svg" alt=""
                                                                             class="correct-icon"
                                                                             v-if="!!answer.is_right"
                                                                             style="position: static; opacity: 1">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div v-if="element.type === 'text'"
                                                             class="d-flex align-items-center mb-4">
                                                            <div class="form-group mb-0 position-relative flex-grow-1">
                                                                <input type="text" class="form-control pr-5"
                                                                       :placeholder="trans('quiz.Enter an answer choice')">
                                                            </div>
                                                        </div>
                                                        <div v-if="element.type === 'dropdown'" class="form-group">
                                                            <select class="form-control" id="exampleSelect1">
                                                                <option v-for="answer in element.answers"
                                                                        :selected="answer.is_right ? 'selected': ''">
                                                                    {{answer.title}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div v-if="element.type === 'textarea'" class="form-group">
                                                            <textarea class="form-control"
                                                                      :placeholder="trans('quiz.Textbox')"></textarea>
                                                        </div>
                                                        <div v-if="element.type === 'file'"
                                                             class="d-flex flex-wrap align-items-start">
                                                            <div class="position-relative block-5 mt-2"
                                                                 v-for="answer in element.answers">
                                                                <img :src="answer.file_url ? answer.file_url : answer.url "
                                                                     alt="">
                                                                <label
                                                                    class="checkbox checkbox-outline checkbox-outline-2x checkbox-success mr-4 mb-0">
                                                                    <input type="checkbox" checked disabled v-if="answer.is_right">
                                                                    <span></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div v-if="element.type === 'circling'">
                                                            <div class="d-flex align-items-center mb-4"
                                                                 v-for="answer in element.answers">
                                                                <label
                                                                    class="radio radio-outline radio-big radio-success mr-4 mb-0 d-flex align-items-center">
                                                                    <input type="checkbox" class="mr-2">
                                                                    {{answer.title}}
                                                                    <span></span>
                                                                </label>
                                                                <img v-if="answer.is_right" src="/img/correct.svg"
                                                                     alt="" class="">
                                                            </div>
                                                            <div class="mt-3">
                                                                <textarea class="form-control"
                                                                          :placeholder="trans('quiz.Textbox')"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </draggable>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="openQuestion && (quiz_id !== null)" class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
            <div class="row">
                <div class="col-xl-10 col-md-12">
                    <div class="kt-portlet">
                        <div class="kt-portlet__body">
                            <self-verification v-bind:quiz_id="quiz_id"></self-verification>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import Question from "./components/question";
    import SelfVerification from "./components/self-verification";
    import draggable from 'vuedraggable';
    import ClickOutside from 'vue-click-outside'
    import CKEditor from 'ckeditor4-vue'
    import Multiselect from 'vue-multiselect'
    import { Datetime } from 'vue-datetime';
    import 'vue-datetime/dist/vue-datetime.css'
    import Self_verification from "./components/self-verification";

    export default {
        name: "quiz_main",
        data() {
            return {
                current_date: this.getCurrentDate(),
                groups: [],
                groups_options: [],
                groups_ids: [],
                company: null,
                companies_options: [],
                is_priority: null,
                editorConfig: {
                    toolbarGroups: [
                        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                        { name: 'forms', groups: [ 'forms' ] },
                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                        { name: 'links', groups: [ 'links' ] },
                        { name: 'insert', groups: [ 'insert' ] },
                        '/',
                        { name: 'styles', groups: [ 'styles' ] },
                        { name: 'colors', groups: [ 'colors' ] },
                        { name: 'tools', groups: [ 'tools' ] },
                        { name: 'others', groups: [ 'others' ] },
                        { name: 'about', groups: [ 'about' ] }
                    ],
                    removeButtons: 'Source,Save,NewPage,ExportPdf,Preview,Print,Templates,Image,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Link,Unlink,Anchor,Flash,About',
                    language: 'de'
                },
                questionInfo: null,
                quiz_is_active: false,
                questionCurrentType: null,
                formChanged: false,
                class_number: 1,
                validationAnswer: false,
                validationAnswerNoVariants: false,
                validationAnswerUploadFile: false,
                quiz_edit_block_show: false,
                questionType: null,
                addOtherQuestionShow: false,
                questionName: '',
                questionId: null,
                question_file_type: '',
                data: [],
                showNavigation: true,
                showQuestionAnswer: true,
                edit: false,
                valid: true,
                question_id: null,
                modal_button_save: false,
                fromButtonShow: false,
                loading: false,
                valid_error: {
                    r_title: false,
                    r_select: false,
                    r_limit: false
                },
                questionNavigation: {
                    type: '',
                    checkLangType: '',
                    inputUrl: true,
                    image: false,
                    url: null,
                    video: false,
                    file: null,
                    file_url: null,
                    class: false,
                    file_type: {
                        name: null,
                        url: true,
                        file: true,
                    },
                },
                exceptionAnswers: [
                    'text',
                    'textarea',
                    'radio'
                ],
                error: {
                    validUrl: false,
                    validUrlYoutube: false,
                    validUploadFile: false
                },
                opened: null,
                __edit: null,
                ___i: null,

                quiz_id: null,
                copyText: '',
                questionData: [],
                title: '',
                description: '',
                time_limit: '',
                multiple: false,
                multipleChoiceType: null,
                dataQuestions: [],
                openQuestion: false,
                quizHide: true,
                quizResponse: null,
                saveOrEdit: true,
                quiz_create_valid: {
                    title: false,
                    description: false,
                    limit_time: false
                },
                is_required_fields: false,
                question_required: null
            }
        },
        components: {
            'self-verification': SelfVerification,
            'app-question': Question,
            ckeditor: CKEditor.component,
            Multiselect,
            Datetime,

        },
        props: [
            'quiz',
            'datatime'
        ],
        methods: {

            isRequiredFields(is_required){
                axios.post(`/dashboard/quiz/${this.quiz_id}/question-fields-required`, {
                    is_required: is_required
                })
            },

            getCurrentDate() {
                var today = new Date();
                var dd = today.getDate();

                var mm = today.getMonth()+1;
                var yyyy = today.getFullYear();
                var hh = today.getHours();
                var ii = today.getMinutes();
                if(dd<10)
                {
                    dd='0'+dd;
                }
                if(hh<10)
                {
                    hh='0'+hh;
                }
                if(ii<10)
                {
                    ii='0'+ii;
                }
                if(mm<10)
                {
                    mm='0'+mm;
                }
                today = yyyy+'-'+mm+'-'+dd + 'T' + hh + ':' + ii + ':00.000+04:00';

                return today;
            },

            onChangeGroups(value){
                this.groups = value;
            },
            onChangeCompanies(value){
                this.company = value;
            },
            setQuestionInfo(question){
                this.questionInfo = question.question_info;
                this.question_id = question.id;
            },
            saveInfo(){
                this.loading = true;
                axios({
                    url: `/dashboard/quiz/${this.quiz_id}/questions/${this.question_id}/questionInfo`,
                    method: 'patch',
                    data: {
                       'question_info': this.questionInfo
                    }
                }).then(response => {
                    $('#questionInfo').modal('hide');
                    this.getAllQuizQuestions();
                    this.loading = false;
                }).catch(error => {

                });

            },
            openedItem(item_id) {
                $('.questionBodyCollapse').map((index, item)=>{
                    if ((item.getAttribute('data-question-id') != item_id))
                        $(item).collapse('hide');
                });
                if (this.__edit) {
                    this.showEditBlock(false, item_id);
                }
                if (this.opened === item_id) {
                    this.opened = 0;
                    this.__edit = 0;
                    return;
                }
                this.__edit = 0;
                this.opened = item_id;

            },
            quizActive(){
                let formData = new FormData();
                formData.append('is_active', this.quiz_is_active);
                axios.patch(`/dashboard/api-quiz-is_active/${this.quiz_id}`, {is_active:this.quiz_is_active})
                    .then()
                    .catch(error => console.log(error))
            },
            questionCountDelete(index)
            {
                this.questionData.splice(index, 1);
            },
            showMessageSelectCorrectAnswer(e) {
                if($(e.target).is(":checked")){
                    $(e.target).siblings('.mobile').addClass('mobile_is_true')
                }else{
                    $(e.target).siblings('.mobile').removeClass('mobile_is_true')
                }
            },
            async deleteAnswer(index) {
                if(this.questionType == 'file'){
                    let imageBlock = document.querySelectorAll('.image-block');
                    if (imageBlock[0]){
                        await imageBlock.forEach(item=>{
                            if (item.getAttribute('data-id') == index){
                                if(item.getAttribute('data-id') == 0){
                                    item.classList.add('d-none')
                                }else {
                                    item.remove()
                                }
                            }
                        })
                    }
                    this.data[index] = {}
                }else {
                    this.$delete(this.data, index);
                }
            },
            validURL(str) {
                let pattern = new RegExp('^(https?:\\/\\/)?' +
                    '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' +
                    '((\\d{1,3}\\.){3}\\d{1,3}))' +
                    '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' +
                    '(\\?[;&a-z\\d%_.~+=-]*)?' +
                    '(\\#[-a-z\\d_]*)?$', 'i');
                return !!pattern.test(str);
            },
            formToEmpty() {
                this.questionName = '';
                this.questionNavigation.type = null;
                this.questionNavigation.url = null;
                this.questionNavigation.file = null;
                this.questionNavigation.file_url = null;
                this.error.validUrlYoutube = false;
                this.error.validUrl = false;
                this.data = [];
                this.questionType = '';
                this.valid = true;
                this.questionCurrentType = null;
                this.addOtherQuestionShow = false;
                this.validationAnswer = false;
                this.validationAnswerNoVariants = false;
                this.validationAnswerUploadFile = false;
            },
            checkURL(url) {
                return (url.match(/\.(jpeg|jpg|gif|png|svg)$/) != null);
            },
            getRadioValue(is_tight, title) {
                this.data = [{}];
                if (is_tight) {
                    this.data[0]['title'] = title;
                    this.data.push({
                        title: 'No',
                        order: 2
                    });
                    this.data[0]['is_right'] = true;
                    this.data[0]['order'] = 1;
                } else {
                    this.data[0]['title'] = title;
                    this.data.push({
                        title: 'Yes',
                        order: 1
                    });
                    this.data[0]['is_right'] = true;
                    this.data[0]['order'] = 2;
                }
            },
            questionNavigationUrlChange() {
                if (this.validURL(this.questionNavigation.url)) {
                    if (this.questionNavigation.file_type.name == 'image' && this.checkURL(this.questionNavigation.url)){
                        this.error.validUrlYoutube = false;
                        this.questionNavigation.type = 'image_url';
                        this.error.validUrl = false;
                        this.modal_button_save = true;
                    }else {
                        this.error.validUrl = true;
                        this.modal_button_save = false;
                    }
                    if (this.questionNavigation.file_type.name == 'video'){
                        this.error.validUrl = false;
                        let video_id = this.questionNavigation.url.split(/\/+/)[1];
                        let ampersandPosition = video_id.indexOf('&');
                        if (ampersandPosition != -1) {
                            video_id = video_id.substring(0, ampersandPosition);
                        }
                        if (video_id == 'www.youtube.com') {
                            this.questionNavigation.type = 'youtube';
                            this.error.validUrlYoutube = false;
                            this.modal_button_save = true;
                        } else {
                            this.error.validUrlYoutube = true;
                            this.modal_button_save = false;
                        }
                    }

                    this.questionNavigation.file_type.file = false;
                    this.formChanged = true;
                } else if (this.questionNavigation.url == "") {
                    this.error.validUrl = false;
                    this.modal_button_save = true;
                } else {
                    this.error.validUrl = true;
                    this.modal_button_save = false;
                }
            },
            questionNavigationFileTypeChange(choose) {
                this.formChanged = false;
                this.questionNavigation.file_type.url = true;
                this.questionNavigation.file_type.file = true;
                this.questionNavigation.url = null;
                this.questionNavigation.file = null;
                this.questionNavigation.file_url = null;
                this.questionNavigation.video = false;
                this.questionNavigation.class = false;
                this.error.validUploadFile = false;
                this.questionNavigation.url = null;
                this.error.validUrl = false;
                this.error.validUrlYoutube = false;
                this.formChanged = false;
                this.questionNavigation.class = false;
                document.getElementById('file').nextElementSibling.innerHTML = choose;
                this.modal_button_save = false;

            },
            checkExceptionAnswers() {
                this.exceptionAnswers.forEach((item) => {
                    if (item == this.questionType) {
                        this.addOtherQuestionShow = false;
                    }
                })
            },
            hide() {
                this.showNavigation = false
            },
            showEditNavigation() {
                this.showNavigation = !this.showNavigation
            },
            addOtherQuestion() {
                if (this.questionType) {
                    this.data.push({});
                    this.edit = false;
                }
            },
            getFileQuestion(e) {
                var that = this;
                let files = e.target.files;
                if (files[0] != undefined) {
                    let currentType = files[0].type.slice(0, 5);
                    if (currentType == 'image' || currentType == 'video'){
                        this.error.validUploadFile = false;
                        if (this.questionNavigation.file_type.name == 'video') {
                            if (currentType == 'video') {
                                this.questionNavigation.type = 'video';
                                var reader = new FileReader();
                                reader.onload = function (file) {
                                    var fileContent = file.target.result;
                                    that.questionNavigation.class = false;
                                    that.questionNavigation.file_url = fileContent;
                                    that.questionNavigation.video = true;
                                };
                                reader.readAsDataURL(files[0]);
                                this.error.validUploadFile = false;
                                this.questionNavigation.file_type.url = false;
                                this.questionNavigation.file = e.target.files[0];
                                this.modal_button_save = true;
                            }else {
                                this.error.validUploadFile = true;
                                that.questionNavigation.video = false;
                                this.questionNavigation.file_url = '';
                                this.modal_button_save = false;
                            }
                        } else {
                            if (currentType == 'image'){
                                this.questionNavigation.type = 'image';
                                this.error.validUploadFile = false;
                                for (let i = 0, f; f = files[i]; i++) {
                                    if (!f.type.match('image.*')) {
                                        continue;
                                    }
                                    let reader = new FileReader();
                                    reader.onload = (function (theFile) {
                                        return function (e) {
                                            that.questionNavigation.file_url = e.target.result;
                                            that.questionNavigation.video = false;
                                            that.questionNavigation.class = true;
                                        };
                                    })(f);
                                    reader.readAsDataURL(f);
                                }
                                this.questionNavigation.file_type.url = false;
                                this.questionNavigation.file = e.target.files[0];
                                this.modal_button_save = true;
                            }else {
                                that.questionNavigation.class = false;
                                this.error.validUploadFile = true;
                                this.questionNavigation.file_url = '';
                                this.modal_button_save = false;
                            }

                        }

                    }else {
                        this.error.validUploadFile = true;
                        this.questionNavigation.file_url = '';
                        this.modal_button_save = false;
                    }

                }
                this.formChanged = true;
            },
            questionNameChange() {
                if (this.questionName == "") {
                    this.valid = false;
                    this.valid_error.r_title = true;
                } else {
                    this.valid = true;
                    this.valid_error.r_title = false;
                }
            },
            clearUserSelectImg(index, choose) {
                // this.answerImgDeleteButtonShow = false;
                this.data.splice(index, 1);
                event.target.nextElementSibling.innerHTML = '<img>';
                event.target.parentElement.nextElementSibling.querySelector('.answer-image').value = '';
                event.target.parentElement.nextElementSibling.querySelector('.answer-image-label').innerHTML = choose;
                // event.target.style.display = 'none';
            },
            questionNavigationControl(type, currentTypeName, choose, questionFileType, currentTypeName__) {
                this.questionNavigation.checkLangType = currentTypeName;
                this.questionNavigation.checkLangType__ = currentTypeName__;
                this.question_file_type = questionFileType;
                if (this.questionNavigation.file_type.name != type) {
                    document.getElementById('file').nextElementSibling.innerHTML = choose;
                    this.questionNavigation.file_type.url = true;
                    this.questionNavigation.file_type.file = true;
                    this.questionNavigation.file_type.name = type;
                    this.error.validUploadFile = false;
                    this.questionNavigation.url = null;
                    this.questionNavigation.file_url = '';
                    this.questionNavigation.video = false;
                    this.questionNavigation.class = false;
                    this.error.validUrl = false;
                    this.error.validUrlYoutube = false;
                    this.formChanged = false;
                }

            },
            getImages(index, e) {
                let files = e.target.files;
                if (files[0]) {
                    let currentType = files[0].type.slice(0, 5);
                    if (currentType == 'image') {
                        this.validationAnswerUploadFile = false;
                        let imgBlock = $(e.target).closest('.image-block').find('.img-preview')[0];
                        // $(imgBlock).siblings('button.userSelectImageIcon')[0].style.display = 'block';
                        imgBlock.innerHTML = '';
                        for (let i = 0, f; f = files[i]; i++) {
                            if (!f.type.match('image.*')) {
                                continue;
                            }
                            let reader = new FileReader();
                            reader.onload = (function (theFile) {
                                return function (e) {
                                    var span = document.createElement('span');
                                    span.innerHTML = ['<img class="thumb rounded" src="', e.target.result,
                                        '" title="', theFile.name, '"/>'].join('');

                                    imgBlock.insertBefore(span, null);
                                };
                            })(f);
                            reader.readAsDataURL(f);
                        }
                        this.data[index].file = e.target.files[0];
                        this.data[index]['file_type'] = 'image';
                        e.target.nextElementSibling.innerHTML = e.target.files[0].name
                    }else {
                        this.validationAnswerUploadFile = true
                    }
                }
            },
            /*chooseRightOption(index) {
                if (this.data[index]['is_right']) {
                    this.data[index]['is_right'] = false;
                    event.target.style.opacity = '0.5'
                } else {
                    this.data[index]['is_right'] = true;
                    event.target.style.opacity = '1'
                }
                console.log(this.data)
            },*/
            async selectQuestionType(name, id, currentName) {
                this.data = [];
                this.questionType = name;
                this.questionCurrentType = currentName;
                this.valid_error.r_select = false;
                this.data.push({});
                this.edit = false;
                this.createAnswer = false;
                this.validationAnswer = false;
                this.validationAnswerNoVariants = false;
                this.addOtherQuestionShow = true;
                this.checkExceptionAnswers();
            },
            async questionUpdate(url, method) {
                let form = new FormData();
                form.append('title', this.questionName);
                form.append('type', this.questionType);
                if (this.is_priority) form.append('is_priority', this.is_priority);
                form.append('_method', 'PATCH');
                if (this.questionNavigation.file) form.append('file', this.questionNavigation.file);
                if (this.questionNavigation.url) form.append('url', this.questionNavigation.url);
                if (this.questionNavigation.type) form.append('file_type', this.questionNavigation.type);
                if (this.question_required) {
                    form.append('question_required', 1);
                }else{
                    form.append('question_required', 0);
                }
                await axios({
                    url: url,
                    method: method,
                    data: form
                }).then(response => {
                    this.valid = true;
                    this.questionId = response.data.data.id;
                }).catch(error => {
                    this.valid = false;
                    console.log(error)
                })
            },
            async questionUpdateSave(question_id) {
                await this.validationAnswers();
                if (this.validationAnswerNoVariants) {
                    this.valid = false;
                } else if (!this.validationAnswer) {
                    if (this.questionType != 'text' && this.questionType != 'textarea') {
                        /*let i = 0;
                        while (i < this.data.length) {
                            if (this.data[i].is_right) {
                                this.validationAnswer = false;
                                break;
                            } else {
                                this.validationAnswer = true;
                            }
                            i++;
                        }*/
                    } else {
                        this.validationAnswer = false;
                    }
                    if (!this.validationAnswer) {
                        if (this.questionName == "") {
                            this.valid = false;
                            this.valid_error.r_title = true;
                            this.valid_error.r_select = false;
                        } else if (this.questionType == "") {
                            this.valid = false;
                            this.valid_error.r_title = false;
                            this.valid_error.r_select = true;
                        } /*else if (this.questionName.length > 255) {
                            this.valid_error.r_title = false;
                            this.valid_error.r_select = false;
                            this.valid_error.r_limit = true;
                            this.valid = false;
                        }*/else {
                            this.valid = true;
                            this.valid_error.r_limit = false;
                            this.valid_error.r_title = false;
                            this.valid_error.r_select = false;
                        }
                        if (this.valid) {
                            this.loading = true;
                            let edit_block = document.querySelectorAll('.card-body');
                            edit_block.forEach((item, index) => {
                                if (item.getAttribute('data-question-id') == question_id) {
                                    item.querySelector('.preview').style.display = 'block';
                                    item.querySelector('.edit-block').style.display = 'none';
                                }
                            });

                            await this.questionUpdate(`/dashboard/quiz/${this.quiz_id}/questions/${question_id}`, 'post');
                            await axios.delete(`/dashboard/questions/${question_id}/answers`).catch(error => {
                                console.log(error)
                            });

                            let formData = new FormData();
                            if (this.questionType == 'file') {
                                for (let i = 0; i < this.data.length; i++) {
                                    let data = this.data[i];
                                    if (data.file_type) formData.append(`data[${i}][file_type]`, data.file_type);
                                    if (data.file) formData.append(`data[${i}][file]`, data.file);
                                    if (data.is_right) {
                                        formData.append(`data[${i}][is_right]`, 1);
                                    } else formData.append(`data[${i}][is_right]`, 0);
                                    if (data.title) formData.append(`data[${i}][title]`, data.title);
                                    if (data.file_url) formData.append(`data[${i}][url]`, data.file_url);
                                    if (data.url) formData.append(`data[${i}][url]`, data.url);
                                }
                            } else {
                                formData = {
                                    data: this.data
                                }
                            }

                            axios.post(`/dashboard/questions/${question_id}/answers`, formData).then(response => {
                                this.getAllQuizQuestions();
                                this.valid = true;
                                this.edit = true;
                                this.createAnswer = false;
                                this.showQuestionEditBLock = false;
                                this.showEditBlock(false, this.question_id);
                                this.loading = false;
                                this.showQuestionAnswer = false;
                                for (let i = 0; i < response.data.data.length; i++) {
                                    this.data[i]['id'] = response.data.data[i].id
                                }
                            }).catch(error => {
                                console.log(error);
                                this.loading = false;
                            })
                        } else {
                            this.valid = false;
                            this.validError = true
                        }
                    }
                }


            },
            showEditBlock(is_show, question_id) {

                if (question_id){
                    if (this.__edit == question_id){
                        this.__edit = 0;
                        is_show = false;
                        this.opened = question_id;
                    }else {
                        $('.questionBodyCollapse').map((index, item)=>{
                            if ((item.getAttribute('data-question-id') != question_id))
                            $(item).collapse('hide');
                        });
                        this.__edit = question_id;
                    }
                }else{
                    $('.questionBodyCollapse').map((index, item)=>{
                        $(item).collapse('hide');
                    });
                }


                let edit_block = document.querySelectorAll('.questionBodyCollapse');
                edit_block.forEach((item) => {
                    item.querySelector('.preview').style.display = 'block';
                    item.querySelector('.edit-block').style.display = 'none';
                    if (is_show) {
                        if (item.getAttribute('data-question-id') == question_id) {
                            item.querySelector('.preview').style.display = 'none';
                            item.classList.add('show');
                            item.querySelector('.edit-block').style.display = 'block';
                        } else {
                            // this.opened = question_id;
                            item.querySelector('.preview').style.display = 'block';
                            item.querySelector('.edit-block').style.display = 'none';
                        }
                    } else {
                        if (item.getAttribute('data-question-id') == question_id) {
                            // this.opened = question_id;
                            item.querySelector('.preview').style.display = 'block';
                            item.querySelector('.edit-block').style.display = 'none';
                        }
                    }
                });
                // document.getElementById(`collapseOne${question_id}`).classList.add('show');
            },
            questionEdit(question, currentType, choose) {

                if (this.questionId != question.id){
                    this.formChanged = false;
                    this.questionNavigation.file_type.url = true;
                    this.questionNavigation.file_type.file = true;
                    this.questionNavigation.url = null;
                    this.questionNavigation.file = null;
                    this.error.validUrlYoutube = false;
                    this.error.validUrl = false;
                    document.getElementById('file').value = "";
                    this.questionNavigation.class = false;
                    document.getElementById('file').nextElementSibling.innerHTML = choose;
                    this.questionNavigation.file_type.name = null;
                }

                this.showQuestionEditBLock = !this.showQuestionEditBLock;

                this.data = [];

                this.questionName = question.title;

                this.question_required = question.question_required;

                this.questionType = question.type;

                this.is_priority = question.is_priority;

                this.checkQuestionTypeName(question.type, currentType);

                this.question_id = question.id;

                this.showEditBlock(true, question.id);

                this.formChanged = true;

                this.questionNavigation.type = question.file_type;

                if (question.file_type == 'image') {
                    this.questionNavigation.file_type.name = 'image';
                    this.questionNavigation.file_type.url = false;
                    this.questionNavigation.file_url = question.file_url;
                    this.questionNavigation.file_type.file = true;
                    this.questionNavigation.video = false;
                    this.questionNavigation.class = true;
                } else if (question.file_type == 'image_url') {
                    this.questionNavigation.file_type.name = 'image';
                    this.questionNavigation.url = question.url;
                    this.questionNavigation.file_type.url = true;
                    this.questionNavigation.file_type.file = false;
                } else if (question.file_type == 'video') {
                    this.questionNavigation.file_type.name = 'video';
                    this.questionNavigation.file_url = question.file_url;
                    this.questionNavigation.file_type.file = true;
                    this.questionNavigation.file_type.url = false;
                    this.questionNavigation.class = false;
                    this.questionNavigation.video = true;
                } else if (question.file_type == 'youtube') {
                    this.questionNavigation.file_type.name = 'video';
                    this.questionNavigation.url = question.url;
                    this.questionNavigation.file_type.url = true;
                    this.questionNavigation.file_type.file = false;
                } else{
                    this.formChanged = false;
                    this.questionNavigation.file_type.url = true;
                    this.questionNavigation.file_type.file = true;
                    this.questionNavigation.url = null;
                    this.questionNavigation.file = null;
                    this.error.validUrlYoutube = false;
                    this.error.validUrl = false;
                    this.questionNavigation.class = false;
                    document.getElementById('file').nextElementSibling.innerHTML = choose;
                    this.questionNavigation.file_type.name = null;
                }

                if (question.answers.length) {
                    question.answers.forEach((item) => {
                        if (item.title == null || item.title == "") {
                            delete item.title;
                        }
                        delete item.file;
                        delete item.id;
                        if (!item.file_type) {
                            delete item.file_type;
                            delete item.file_url;
                            delete item.url;
                        }
                        if (item.file_url =='https://aist-elearning.s3.eu-central-1.amazonaws.com/CixbCxTd4rko/'){

                        }
                        delete item.question_id;
                        delete item.created_at;
                        delete item.deleted_at;
                        this.data.push(item)
                    });
                    if (this.data) this.addOtherQuestionShow = true;
                }

                this.exceptionAnswers.forEach(item => {
                    if (question.type == item) {
                        this.addOtherQuestionShow = false;
                    }
                });

            },
            checkQuestionTypeName(question_type, currentType) {
                if (question_type == 'multiple') this.questionCurrentType = currentType[0];
                else if (question_type == 'radio') this.questionCurrentType = currentType[1];
                else if (question_type == 'dropdown') this.questionCurrentType = currentType[2];
                else if (question_type == 'text') this.questionCurrentType = currentType[3];
                else if (question_type == 'file') this.questionCurrentType = currentType[4];
                else if (question_type == 'textarea') this.questionCurrentType = currentType[5];
                else if (question_type == 'circling') this.questionCurrentType = currentType[6];
            },
            async validationAnswers() {
                this.validationAnswerNoVariants = false;
                this.validationAnswer = false;
                if (this.questionType !== '') {
                    if (this.questionType != 'text' && this.questionType != 'textarea') {
                        if (this.questionType == 'file') {
                            await this.data.forEach((item, index) => {
                                if (_.isEmpty(item)) {
                                    this.$delete(this.data, index)
                                }
                            });
                            if (this.data[0]) {
                                let i = 0;
                                while (i < this.data.length) {
                                    if (this.data[i].file || this.data[i].file_url || this.data[i].url) {
                                        if (this.data[i].is_right) {
                                            this.validationAnswer = false;
                                            break;
                                        } else {
                                            this.validationAnswer = true;
                                        }
                                    } else {
                                        this.validationAnswer = true;
                                        break;
                                    }
                                    i++;
                                }
                            } else {
                                this.validationAnswer = true;
                            }
                        } else {
                            if (this.questionType == 'radio') {
                                let i = 0;
                                while (i < this.data.length) {
                                    if (this.data[i].is_right != undefined) {
                                        this.validationAnswer = false;
                                        break;
                                    } else {
                                        this.validationAnswer = true;
                                    }
                                    i++;
                                }
                            } else {
                                if (this.data.length !== 0) {
                                    let i = 0;
                                    while (i < this.data.length) {
                                        if (this.data[i].title == undefined || this.data[i].title == "") {
                                            this.validationAnswer = true;
                                            break;
                                        } else {
                                            this.validationAnswer = false;
                                        }
                                        i++;
                                    }
                                } else {
                                    this.validationAnswerNoVariants = true;
                                }
                            }
                        }
                    } else {
                        this.validationAnswer = false;
                    }
                }
            },
            async createQuiz() {
                if(this.validation()){
                    $.each(this.groups, (key, value) => {
                        this.groups_ids.push(value.id)
                    });
                    let form = new FormData(), url;
                    form.append('title', this.title);
                    form.append('description', this.description);
                    // form.append('class', this.class_number);
                    form.append('groups_ids', this.groups_ids);
                    form.append('company_id', this.company ? this.company.id : null);
                    if (this.time_limit) form.append('time_limit', this.time_limit);
                    this.loading = true;
                    if (!this.quizResponse && !this.quiz_id ) {
                        url = '/dashboard/api-quiz';
                        await this.sendMethod(url, 'post', form);
                    } else {
                        form.append('answer_by_one', 0);
                        form.append('_method', 'PATCH');
                        url = '/dashboard/api-quiz/' + this.quiz_id + "/update";
                        await this.sendMethod(url, 'post', form);
                    }
                }


            },
            quizEdit() {
                this.saveOrEdit = true;
                this.quizHide = true
            },
            async cloneQuestion(question_id) {
                await axios.post(`/dashboard/quiz/${this.quiz_id}/questions/${question_id}`)
                    .then(response => {
                        this.getAllQuizQuestions();
                    }).catch(error => {
                    });
            },
            addNewQuestion() {
                this.questionData.push({
                    check:true
                });
                if ($('.questionItem').last().length){
                    $('html, body').animate({
                        scrollTop: $('.questionItem').last().offset().top
                    }, 700);
                }else {
                    $('html, body').animate({
                        scrollTop: $("#kt-portlet__body").offset().top
                    }, 700);
                }
            },
            sendMethod(url, method, form) {
                axios({
                    url: url,
                    method: method,
                    data: form,
                    headers: {'Content-Type': 'multipart/form-data'}
                }).then(response => {
                    this.quiz_id = response.data.data.id;
                    this.quizResponse = response.data;
                    this.openQuestion = true;
                    this.saveOrEdit = false;
                    this.loading = false;
                    this.quizHide = false;
                    this.quiz_create_valid.limit_time = false
                }).catch(error => {
                    // this.validation();
                    // console.log(error.responseData)
                    if(error.response.data.errors.time_limit.length){
                        this.quiz_create_valid.limit_time = error.response.data.errors.time_limit
                    }
                    console.log(error.response.data.errors.title);
                    this.loading = false;
                })
            },
            questionDelete(questionId, index) {
                axios.delete(`/dashboard/quiz/${this.quiz_id}/questions/${questionId}`)
                    .then(resp => {
                        this.getAllQuizQuestions();
                    }).catch(error => {
                    console.log(error)
                })
            },
            validation() {
                let i = 0;
                /*let parsTimeLimit = parseInt(this.time_limit);
                if (parsTimeLimit){
                    if (parsTimeLimit <= 0 || parsTimeLimit > 9999) {
                        this.quiz_create_valid.limit_time = true;
                        i++
                    } else {
                        this.quiz_create_valid.limit_time = false;
                    }
                }else {
                    i++;
                    this.quiz_create_valid.limit_time = true;
                    if (this.time_limit == "" || this.time_limit == null){
                        i = 0;
                        this.quiz_create_valid.limit_time = false;
                    }
                }*/
                if (this.title == "" || this.title.length > 255) {
                    this.quiz_create_valid.title = true;
                    i++
                } else {
                    this.quiz_create_valid.title = false;
                }
                if (this.description == "") {
                    this.quiz_create_valid.description = true;
                    i++
                } else {
                    this.quiz_create_valid.description = false;
                }

                if (i > 0) {
                    return false
                } else return true
            },
            allQuestions(data) {
                this.dataQuestions = data.data.data
            },
            async changeQuestions() {
                var obj = {};
                this.dataQuestions.map(function (val, index) {
                    val.order = index + 1;
                    obj[val.id] = val.order
                });
                await axios({
                    method: 'patch',
                    url: `/dashboard/quiz/${this.quiz_id}/questions`,
                    data: {
                        ids: obj
                    },
                    header: {
                        'Content-Type': 'application/json'
                    }
                }).then(response => {
                    this.dataQuestions = response.data.data;
                }).catch(error => {
                    console.log(error)
                })
            },
            async getAllQuizQuestions() {
                await axios.get(`/dashboard/quiz/${this.quiz_id}/questions`)
                    .then(response => {
                        this.dataQuestions = response.data.data;
                        this.questionData = [];
                        for (let i = 0; i < response.data.data.length; i++) {
                            if (i == response.data.data.length - 1 && this.___i) {
                                this.questionData.push({
                                    check: true
                                });
                                this.___i = true;
                            } else {
                                this.questionData.push({
                                    check: false
                                })
                            }
                        }
                    }).catch(error => {
                        console.log(error)
                    })
            },
            async getGroups() {
                let url = '';
                if (this.quiz_id){
                    url = `/dashboard/api/quiz-groups/${this.quiz_id}`;
                }else{
                    url = `/dashboard/api/quiz-groups`;
                }

                await axios.get(url)
                .then(response=>{
                    this.groups = response.data.selected_group;
                    this.groups_options = response.data.groups;
                })
            },
            async getCompanies() {
                let url = '';
                if (this.quiz_id){
                    url = `/dashboard/api/quiz-companies/${this.quiz_id}`;
                }else{
                    url = `/dashboard/api/quiz-companies`;
                }

                await axios.get(url)
                .then(response=>{
                    this.company = response.data.selected_company;
                    this.companies_options = response.data.companies;
                })
            },
            async init() {

                if (this.quiz) {
                    this.quiz_id = this.quiz.id;
                    this.openQuestion = true;
                    this.title = this.quiz.title;
                    this.description = this.quiz.description;
                    this.class_number = this.quiz.class;
                    this.is_required_fields = this.quiz.is_required_fields;
                    this.time_limit =  this.datatime;
                    this.quizHide = false;
                    if (this.quiz.is_active)
                    this.quiz_is_active = true;
                    this.getAllQuizQuestions();
                }

            }
        },
        mounted() {
        },
        async created() {

            if (this.quiz) {
                this.init();
            } else this.questionData.push({
                check: true
            });
            await this.getGroups();
            await this.getCompanies();
        },
        directives: {
            ClickOutside
        },
        computed: {
            dragOptions() {
                return {
                    animation: 200,
                    group: "description",
                    disabled: false,
                    ghostClass: "ghost",
                    handle: '.my-handle'
                };
            }
        }
    }
</script>


<style scoped lang="scss">

    .active{
        background: #ddd!important;
    }
    .answer-delete-btn {
        background: #ddd;
        border: none;
        font-size: 10px;
        width: 25px;
        height: 25px;
        margin-right: 10px;
        margin-left: -10px;
        transition: .2s;
        margin-left: 0;
        &:hover {
            color: #fff;
            background: #5766db;
        }

        border-radius: 48%;
    }

    .quiz-question-title-ellipsis {
        display: block;
        text-overflow: ellipsis;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
    }

    .my-style {
        width: 80px !important;
        height: 80px !important;
        border-radius: 4px;
        overflow: hidden;
    }

    .my-handle {
        cursor: move;
    }

    .questionItem {
        margin-bottom: 20px;

        &:first-child {
            margin-top: 0;
        }
    }

    .open {
        display: block;
    }

    .edit-block {
        display: none;
    }

    .preview {
        display: block;
    }

    ._show {
        opacity: 1 !important;
        visibility: visible !important;
    }

    .error {
        display: block !important;
    }

    .valid {
        color: red;
    }

    .questionsNavigationButton {
        background: rgba(0, 0, 0, 0.34);
        border-radius: 3px;
        overflow: hidden;
        transition: .2s;
        opacity: 0;
        visibility: hidden;

        button {
            margin: 0;
            height: 25.5px;
            border: none;
            background: transparent;

            svg {
                fill: #fff
            }

            &:hover {
                background: #ddd;
            }
        }
    }


    @media (max-width: 768px) {
        .questionItemEdit{
            padding-left: 1.25rem!important;
            .dropdown{
                width: 100%;
            }
        }
    }
    @media (min-width: 768px) {
        .questionItemEdit{
            .dropdown{
                width: 60%;
            }
        }
    }
    .material-switch > input[type="checkbox"] {
        display: none;
    }

    .material-switch > label {
        cursor: pointer;
        height: 0px;
        position: relative;
        width: 40px;
    }

    .material-switch > label::before {
        background: rgb(0, 0, 0);
        box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
        border-radius: 8px;
        content: '';
        height: 16px;
        margin-top: -8px;
        position:absolute;
        opacity: 0.3;
        transition: all 0.4s ease-in-out;
        width: 40px;
    }
    .material-switch > label::after {
        background: rgb(255, 255, 255);
        border-radius: 16px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
        content: '';
        height: 24px;
        left: -4px;
        margin-top: -8px;
        position: absolute;
        top: -4px;
        transition: all 0.3s ease-in-out;
        width: 24px;
    }
    .material-switch > input[type="checkbox"]:checked + label::before {
        background: inherit;
        opacity: 0.5;
    }
    .material-switch > input[type="checkbox"]:checked + label::after {
        background: #0aba86;
        left: 20px;
    }

    .rotate{
        transform: rotate(180deg);
    }
    .mx-datepicker{
        width: 100%!important;
    }
</style>
