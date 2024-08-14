<template>
    <div class="comment">
        <div class="line"></div>
        <p class="name">{{ comment.name }}</p>
        <div class="d-flex gap-3">
            <p class="timestamp">{{formatterDate(comment.created_at)}}</p>
            <p class="edit">Редактировать</p>
        </div>
        <div class="body">
            <p>{{comment.text}}</p>
        </div>
        <p class="reply">-Ответить</p>
        <div class="line"></div>
    </div>
</template>

<script>
export default {
    name: "CommentComponent",
    props: {
        comment: {
            type: Object,
            required:true
        }
    },
    methods:{
        formatterDate(created_at){
            let timeDate = created_at.split('T');
            const date = timeDate[0];
            const time = timeDate[1].slice(0, 5);
            return `${date} в ${time}`
        }
    }
}
</script>

<style scoped>
.comment {
    max-width: 600px;
    margin-bottom: 20px;
}
.name{
    font-weight: 500;
    margin-bottom: 10px;
    margin-top: 15px;
}
.timestamp{
    color: #3C87AF;
}
.edit{
    color: #8C8C8C;
    cursor: pointer;
}
.body{
    margin-top: 25px;
    margin-bottom: 25px;
}
.line{
    width: 100%;
    height: 1px;
    background-color: #194156;
}
.reply{
    margin-bottom: 15px;
}
</style>
