M.tool_autodeletecourses = {
    init_course_table: function(Y) {
        var perpage = Y.one('#id_perpage');
        perpage.on('change', function(e) {
            window.onbeforeunload = null;
            Y.one('.tool_autodeletecourses_paginationform form').submit();
        });
    }
};
