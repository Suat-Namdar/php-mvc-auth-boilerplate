$(document).ready(function () {
  const $sidebar = $("#sidebar");
  const $openSidebar = $("#openSidebar");
  const $closeSidebar = $("#closeSidebar");
  const $dropdown = $("#dropdown");
  const $dropdownTrigger = $("#dropdownTrigger");

  function clickOutside($element, event) {
    return !$element.is(event.target) && !$element.has(event.target).length;
  }

  function setActiveSidebarLinks() {
    const currentUrl = window.location.pathname;
    $("#sidebar a").each(function () {
      const route = $(this).data("route");
      if (currentUrl.includes(route)) {
        $(this)
          .addClass("bg-cyan-500 text-white")
          .removeClass("hover:bg-gray-100");
      }
    });
  }

  $closeSidebar.on("click", function () {
    $sidebar.removeClass("!translate-x-0");
  });

  $openSidebar.on("click", function () {
    $sidebar.addClass("!translate-x-0");
  });

  $dropdownTrigger.on("click", function () {
    $dropdown.toggleClass("hidden");
  });

  $(document).on("click", function (event) {
    if (clickOutside($sidebar, event) && clickOutside($openSidebar, event)) {
      $sidebar.removeClass("!translate-x-0");
    }
    if (
      clickOutside($dropdown, event) &&
      clickOutside($dropdownTrigger, event)
    ) {
      $dropdown.addClass("hidden");
    }
  });

  setActiveSidebarLinks();
});

function closeAlert() {
  const alert = document.querySelector('[role="alert"]');
  alert.remove();
}

const sidebar = document.getElementById('sidebar');
const openSidebarBtn = document.getElementById('openSidebar');

if (sidebar && openSidebarBtn) {
    openSidebarBtn.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
    });
}