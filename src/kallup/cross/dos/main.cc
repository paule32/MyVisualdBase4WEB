// ------------------------------------------------------
// File    : src/cross/dos/main.cc
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------

// ms-windows header's:
# include <windows.h>
# include <commctrl.h>
# include "resource.h"

// common header's:
# include <stdlib.h>
# include <stdio.h>
# include <malloc.h>
# include <memory.h>
# include <tchar.h>

// common std c++ header's:
# include <algorithm>

# undef  MAX_LOADSTRING
# define MAX_LOADSTRING 100

TCHAR szTitle     [MAX_LOADSTRING];
TCHAR szClassName [MAX_LOADSTRING];

HINSTANCE hInst;
HWND      hWindow;

static const UINT_PTR windowPanelID = 1;

static UINT HANDLED_MESSAGE[] = {
	WM_SHOWWINDOW,
	WM_INITMENUPOPUP,
	WM_SYSCOMMAND,
	WM_SETTEXT,
	WM_NCPAINT,
	WM_NCCALCSIZE,
	WM_SIZE,
	WM_NCACTIVATE,
	WM_NCHITTEST,
	WM_NCLBUTTONUP,
	WM_NCLBUTTONDOWN,
	WM_NCLBUTTONDBLCLK,
	WM_NCRBUTTONUP,
	WM_NCRBUTTONDOWN,
	WM_NCMOUSEMOVE,
	WM_GETMINMAXINFO,
	WM_WINDOWPOSCHANGING,
	WM_SIZING,
	WM_ACTIVATE
};

# define MESSAGE_COUNT 19

void skinWinCTOR();
void skinWinDTOR();

void skinWinLoad(HINSTANCE, HWND);
void LoadBitmapFromResource();
void FreeBitmap();
void skinWinFree();
void CalcResourceInfo();

BOOL IsHandledMessage(UINT message);

LRESULT     WndProc      (HWND, UINT, WPARAM, LPARAM);
LRESULT skinWndProc      (HWND, UINT, WPARAM, LPARAM);

int newWindowRectWidth;
int newWindowRectHeight;

int oldWindowRectWidth;
int oldWindowRectHeight;

void OnNcPaint           (HWND, UINT, WPARAM, LPARAM);
void OnNcActive          (HWND, UINT, WPARAM, LPARAM);
void OnNcCalcSize        (HWND, UINT, WPARAM, LPARAM);

UINT OnNcHitTest         (HWND, UINT, WPARAM, LPARAM);

void OnNcLButtonUp       (HWND, UINT, WPARAM, LPARAM);
void OnNcLButtonDown     (HWND, UINT, WPARAM, LPARAM);
void OnNcLButtonDblClk   (HWND, UINT, WPARAM, LPARAM);
void OnNcMouseMove       (HWND, UINT, WPARAM, LPARAM);
void OnNcRButtonUp       (HWND, UINT, WPARAM, LPARAM);
void OnNcRButtonDown     (HWND, UINT, WPARAM, LPARAM);
void OnSize              (HWND, UINT, WPARAM, LPARAM);
void OnSizing            (HWND, UINT, WPARAM, LPARAM);
void OnActive            (HWND, UINT, WPARAM, LPARAM);
void OnWindowPosChanging (HWND, UINT, WPARAM, LPARAM);
void OnGetMinMaxInfo     (HWND, UINT, WPARAM, LPARAM);
void OnSetText           (HWND, UINT, WPARAM, LPARAM);
void OnSysCommand        (HWND, UINT, WPARAM, LPARAM);

void DrawFrame  (HDC hDc, int x, int y, int width, int height, int state);

void DrawTitle  (HDC hDc, int x, int y, int width, int state);
void DrawBottom (HDC hDc, int x, int y, int width, int state);

void DrawLeft   (HDC hDc, int x, int y, int height, int state);
void DrawRight  (HDC hDc, int x, int y, int height, int state);

BOOL DrawButton (HDC hDc, int index, int state);

HRGN CreateRgnFromColor(HBITMAP, COLORREF);
HRGN CreateRegionFromBitmap(HBITMAP, COLORREF);
HRGN BitmapToRegion(HBITMAP hBmp, COLORREF cTransparentColor = 0, COLORREF cTolerance = 0x101010);

HRGN GetRegion(HDC hDc, int width, int height);
RECT GetButtonRect(int index);

void MyTransparentBlt(HDC, int, int, int, int, HBITMAP, int, int, COLORREF, HPALETTE);
bool TransparentBltA(
	HDC dcDest,         // handle to Dest DC
	int nXOriginDest,   // x-coord of destination upper-left corner
	int nYOriginDest,   // y-coord of destination upper-left corner
	int nWidthDest,     // width of destination rectangle
	int nHeightDest,    // height of destination rectangle
	HDC dcSrc,          // handle to source DC
	int nXOriginSrc,    // x-coord of source upper-left corner
	int nYOriginSrc,    // y-coord of source upper-left corner
	int nWidthSrc,      // width of source rectangle
	int nHeightSrc,     // height of source rectangle
	UINT crTransparent  // color to make transparent
);

void TransparentBltB(
	HDC hdcDest,		// handle to Dest DC
	int nXOriginDest,   // x-coord of destination upper-left corner
	int nYOriginDest,   // y-coord of destination upper-left corner
	int nWidthDest,     // width of destination rectangle
	int nHeightDest,    // height of destination rectangle
	HDC hdcSrc,         // handle to source DC
	int nXOriginSrc,    // x-coord of source upper-left corner
	int nYOriginSrc,    // y-coord of source upper-left corner
	int nWidthSrc,      // width of source rectangle
	int nHeightSrc,     // height of source rectangle
	UINT crTransparent  // color to make transparent
);

BOOL MaximizeWindow();
BOOL MinimizeWindow();
BOOL RestoreWindow();

RECT GetMaximizeRect();

HDC m_MemDC;
HDC m_SkinDC;
HDC m_RegionDC;

//bitmap resources
HBITMAP m_hLeftBmp;
HBITMAP m_hTopBmp;
HBITMAP m_hRightBmp;
HBITMAP m_hBottomBmp;
HBITMAP m_hMinBtnBmp;
HBITMAP m_hMaxBtnBmp;
HBITMAP m_hRestoreBtnBmp;
HBITMAP m_hCloseBtnBmp;
HBITMAP m_hBtnMemBmp;
HBITMAP m_hBtnMaskBmp;

//memory bitmaps
HBITMAP m_MemBitmap;
HBITMAP m_OldMemBitmap;
HBITMAP m_OldSkinBitmap;

//font
HFONT m_hFont;
HFONT m_hOldFont;

//bitmap's information
BITMAP bmpLeft;
BITMAP bmpTop;
BITMAP bmpRight;
BITMAP bmpBottom;
BITMAP bmpMinBtn;
BITMAP bmpMaxBtn;
BITMAP bmpRestoreBtn;
BITMAP bmpCloseBtn;

//caption button's rectangle
RECT minBtnRect;
RECT maxBtnRect;
RECT restoreBtnRect;
RECT closeBtnRect;

RECT RestoreWinRect;

char* WindowText;

int LeftOffset1, LeftOffset2;
int RightOffset1, RightOffset2;
int TopOffset1, TopOffset2;
int BottomOffset1, BottomOffset2;

int BorderLeftWidth;
int BorderRightWidth;
int BorderTopHeight;
int BorderBottomHeight;

HINSTANCE m_hInst;
HWND m_hWnd;

BOOL IsActive;
BOOL m_Loaded;

COLORREF clrTrans;

BOOL m_sizable;
BOOL m_minable;
BOOL m_maxable;
BOOL m_sysmenu;
UINT m_mousedown;

int m_winstate, m_oldwinstate;

UINT m_oldHitTest;
UINT m_moveHitTest;
UINT m_downHitTest;

BOOL m_bTrans;

// -----------------------------------------------------
// paint colored application window.
// -----------------------------------------------------
LRESULT
paintWindowProc(
	HWND hwnd,
	WPARAM wParam,
	LPARAM lParam)
{
	HDC hdc;
	PAINTSTRUCT ps;
	
	hdc = BeginPaint(hwnd, &ps);
	
	RECT mRect;
	GetClientRect(hwnd, &mRect);
	
	HBRUSH redBrush = CreateSolidBrush( RGB(255,0,0) );
	FrameRect(hdc, &mRect, redBrush);
	DeleteObject(redBrush);
	
	EndPaint(hwnd, &ps);
	return 0;
}

// -----------------------------------------------------
// sub class WndProc
// -----------------------------------------------------
LRESULT
subWndProc(
	HWND hwnd,
	UINT msg,
	WPARAM wParam,
	LPARAM lParam,
	UINT_PTR subID,
	DWORD_PTR refdata)
{
	if (msg == WM_PAINT) {
		paintWindowProc(hwnd, wParam, lParam);
		return 0;
	}

	return DefSubclassProc(hwnd, msg, wParam, lParam);
}

// -----------------------------------------------------
// my about dialog :-)
// -----------------------------------------------------
LRESULT CALLBACK
dlgAboutProc(
	HWND hwnd,
	UINT msg,
	WPARAM wParam,
	LPARAM lParam)
{
	switch (msg) {
		case WM_INITDIALOG:
			return TRUE;
		break;
		case WM_COMMAND:
			if (LOWORD(wParam) == IDOK
			||  LOWORD(wParam) == IDCANCEL) {
				EndDialog(hwnd, LOWORD(wParam));
				return TRUE;
			}
		break;
	}
	return 0;
}

// -----------------------------------------------------
// application window entry procedure.
// -----------------------------------------------------
LRESULT CALLBACK
WndProc(
	HWND hwnd,
	UINT msg,
	WPARAM wParam,
	LPARAM lParam)
{
	HWND windowPanel;
	int wmID, wmEvent;
	PAINTSTRUCT ps;
	HDC hdc;
	
	if (IsHandledMessage(msg))
		skinWndProc(hwnd, msg, wParam, lParam);
	
	switch (msg) {
		case WM_INITDIALOG:
			//SetWindowSubclass(windowPanel, subWndProc, windowPanelID, 0);
			return TRUE;
		break;
		case WM_CLOSE:
			DestroyWindow(hwnd);
			return TRUE;
		break;
		case WM_DESTROY:
			//RemoveWindowSubclass(windowPanel, subWndProc, windowPanelID);
			PostQuitMessage(0);
			return FALSE;
		break;
		case WM_COMMAND:
			wmID    = LOWORD(wParam);
			wmEvent = HIWORD(wParam);
			switch (wmID) {
				case IDM_ABOUT:
					DialogBox(hInst, (LPCTSTR)IDD_ABOUTBOX, hwnd, (DLGPROC)dlgAboutProc);
				break;
				case IDM_EXIT:
					DestroyWindow(hwnd);
				break;
				default:
					return DefWindowProc(hwnd, msg, wParam, lParam);
				break;
			}
			return TRUE;
		break;
		case WM_NCACTIVATE:
		case WM_SHOWWINDOW:
			OnNcPaint(hWnd, message, wParam, lParam);
			return 0;
		break;
		case WM_PAINT:
			hdc = BeginPaint(hwnd, &ps);
			{
				// right bottom border
				RECT rect;
				GetWindowRect(hWindow, &rect);
				
				SelectObject  (hdc, GetStockObject(DC_PEN));
				SetDCPenColor (hdc, RGB(0,0,200));
				
				HPEN pen = CreatePen(PS_SOLID, 3, RGB(0,0,200));
				SelectObject(hdc, pen);
				
				// maximized
				if (m_winstate == 1) {
					Rectangle(hdc, 0,0,
						rect.right,
						rect.bottom);
				}
				// notmal
				else {
					Rectangle(hdc, 0,0,
						newWindowRectWidth,
						newWindowRectHeight);
				}
				DeleteObject(pen);
			}
			EndPaint(hwnd, &ps);
		break;
		default:
			return DefWindowProc(hwnd, msg, wParam, lParam);
		break;
	}
	return 0;
}

// -----------------------------------------------------
// main: EntryPoint of application.
// -----------------------------------------------------
int APIENTRY
WinMain(
	HINSTANCE hInstance,
	HINSTANCE hInstPrev,
	PSTR cmdline,
	int cmdshow)
{
	WNDCLASSEX wc;
	HWND hwnd;
	MSG msg;
	HACCEL hAccelTable;
	
	// resource strings:
	LoadString(hInstance, IDS_APP_TITLE, szTitle,     MAX_LOADSTRING);
	LoadString(hInstance, IDC_DOSWINDOW, szClassName, MAX_LOADSTRING);
	
	// register the window class:
	wc.cbSize		 = sizeof(WNDCLASSEX);
	wc.style		 = 0;
	wc.lpfnWndProc	 = (WNDPROC) WndProc;
	wc.cbClsExtra	 = 0;
	wc.cbWndExtra	 = 0;
	wc.hInstance	 = hInstance;
	wc.hIcon		 = LoadIcon(hInstance, (LPCSTR) IDC_DOSWINDOW);
	wc.hCursor	 	 = LoadCursor(NULL, IDC_ARROW);
	wc.hbrBackground = (HBRUSH)CreateSolidBrush(RGB(0,0,0));
	wc.lpszMenuName  = nullptr;
	wc.lpszClassName = szClassName;
	wc.hIconSm		 = LoadIcon(nullptr, IDI_APPLICATION);
	
	if (!RegisterClassEx(&wc)) {
		MessageBox(nullptr,
			"Window Registration Failed!",
			"Error",
			MB_ICONEXCLAMATION | MB_OK);
		return 1;
	}
	
	newWindowRectWidth  = 400;
	newWindowRectHeight = 400;
	
	// create the window:
	if (!(hwnd = CreateWindowEx(
		0,
		szClassName,
		szTitle,
		WS_OVERLAPPEDWINDOW,
		CW_USEDEFAULT, 
		CW_USEDEFAULT,
		400, 400,
		NULL, NULL,
		hInstance, NULL))) {
		MessageBox(nullptr,
			"Window Creation Failed!",
			"Error",
			MB_ICONEXCLAMATION | MB_OK);
		return 1;
	}
	
	hWindow  = hwnd;
	IsActive = TRUE;
	
	InitCommonControls();
	
	skinWinLoad(hInstance, hwnd);
	
	ShowWindow(hwnd, cmdshow);
	UpdateWindow(hwnd);
	
	// the message loop:
	while (GetMessage(&msg, nullptr, 0, 0) > 0) {
		if (!TranslateAccelerator(msg.hwnd, hAccelTable, &msg)) {
			TranslateMessage(&msg);
			DispatchMessage(&msg);
		}
	}
	
	skinWinFree();
	skinWinDTOR();

    return (int) msg.wParam;
}

void
skinWinDTOR(void)
{
	//release resource
	FreeBitmap();
	if (WindowText) {
		free(WindowText);
		WindowText = NULL;
	}

	if (m_MemDC   ) DeleteDC (m_MemDC);
	if (m_SkinDC  ) DeleteDC (m_SkinDC);
	if (m_RegionDC) DeleteDC (m_RegionDC);
	if (m_hFont   ) DeleteObject(m_hFont);
}

void
skinWinLoad(
	HINSTANCE hInst,
	HWND hWnd)
{
	m_hInst = hInst;
	m_hWnd = hWnd;

	HDC WindowDC = GetWindowDC(hWnd);
	
	if (!m_MemDC)    m_MemDC    = CreateCompatibleDC ( WindowDC );
	if (!m_SkinDC)   m_SkinDC   = CreateCompatibleDC ( WindowDC );
	if (!m_RegionDC) m_RegionDC = CreateCompatibleDC ( WindowDC );

	// create font
	if (!m_hFont) {
		char sFontFace[] = "Tahoma";

		LOGFONT lf;
		ZeroMemory( &lf, sizeof(lf) );
		lf.lfHeight			= 13;
		lf.lfWeight			= FW_BOLD;
		lf.lfCharSet		= DEFAULT_CHARSET;
		lf.lfQuality		= DEFAULT_QUALITY;
		lf.lfOutPrecision	= OUT_DEFAULT_PRECIS;
		lf.lfClipPrecision	= CLIP_DEFAULT_PRECIS;
		lf.lfPitchAndFamily	= DEFAULT_PITCH|FF_DONTCARE;
		strcpy( lf.lfFaceName, sFontFace );

		m_hFont = CreateFontIndirect(&lf);
	}

	//1 load bitmap from resource
	LoadBitmapFromResource();

	//2 calculate resource's information
	CalcResourceInfo();

	//3 config current window's style
	DWORD style = GetWindowLong( m_hWnd, GWL_STYLE );
	m_sizable = style & WS_SIZEBOX;
	m_minable = style & WS_MINIMIZEBOX;
	m_maxable = style & WS_MAXIMIZEBOX;
	style &= ~(WS_MINIMIZEBOX);
	style &= ~WS_MAXIMIZEBOX;
	style &= ~WS_SYSMENU;
	SetWindowLong( m_hWnd, GWL_STYLE, style );
}

void
CalcResourceInfo()
{
	// bitmap's information
	GetObject ( m_hLeftBmp      , sizeof( BITMAP ), &bmpLeft       );
	GetObject ( m_hTopBmp       , sizeof( BITMAP ), &bmpTop        );
	GetObject ( m_hRightBmp     , sizeof( BITMAP ), &bmpRight      );
	GetObject ( m_hBottomBmp    , sizeof( BITMAP ), &bmpBottom     );
	GetObject ( m_hMinBtnBmp    , sizeof( BITMAP ), &bmpMinBtn     );
	GetObject ( m_hMaxBtnBmp    , sizeof( BITMAP ), &bmpMaxBtn     );
	GetObject ( m_hRestoreBtnBmp, sizeof( BITMAP ), &bmpRestoreBtn );
	GetObject ( m_hCloseBtnBmp  , sizeof( BITMAP ), &bmpCloseBtn   );

	BorderLeftWidth    = bmpLeft.bmWidth    / 2;
	BorderRightWidth   = bmpRight.bmWidth   / 2;
	BorderTopHeight    = bmpTop.bmHeight    / 2;
	BorderBottomHeight = bmpBottom.bmHeight / 2;

	TopOffset1 = 40;
	TopOffset2 = bmpTop.bmWidth - 60;
	if(TopOffset2 <= TopOffset1)
		TopOffset2 = TopOffset1 + 1;

	LeftOffset1 = 29;
	LeftOffset2 = bmpLeft.bmHeight - LeftOffset1;
	if(LeftOffset2 <= LeftOffset1)
		LeftOffset2 = LeftOffset1 + 1;

	RightOffset1 = 29;
	RightOffset2 = bmpRight.bmHeight - RightOffset1;
	if(RightOffset2 <= RightOffset1)
		RightOffset2 = RightOffset1 + 1;

	BottomOffset1 = 0;
	BottomOffset2 = bmpBottom.bmWidth - 0;
	if(BottomOffset2 <= BottomOffset1)
		BottomOffset2 = BottomOffset1 + 1;

	clrTrans = RGB(255, 0, 255);
	IsActive = FALSE;
	m_bTrans = TRUE;

	//caption button's position
	SetRect ( &minBtnRect, 74-bmpMinBtn.bmWidth/3, 4, 74, 4+bmpMinBtn.bmHeight);
	SetRect ( &maxBtnRect, 50-bmpMaxBtn.bmWidth/3, 4, 50, 4+bmpMaxBtn.bmHeight);
	SetRect ( &restoreBtnRect, 50-bmpRestoreBtn.bmWidth/3, 4, 50, 4+bmpRestoreBtn.bmHeight);
	SetRect ( &closeBtnRect, 27-bmpCloseBtn.bmWidth/3, 4, 27, 4+bmpCloseBtn.bmHeight);
}

void
LoadBitmapFromResource()
{
	if (!m_hInst) return;

	m_hLeftBmp       = LoadBitmap( m_hInst, MAKEINTRESOURCE(IDB_LEFT)    );
	m_hTopBmp        = LoadBitmap( m_hInst, MAKEINTRESOURCE(IDB_TOP)     );
	m_hRightBmp      = LoadBitmap( m_hInst, MAKEINTRESOURCE(IDB_RIGHT)   );
	m_hBottomBmp     = LoadBitmap( m_hInst, MAKEINTRESOURCE(IDB_BOTTOM)  );

	m_hMinBtnBmp     = LoadBitmap( m_hInst, MAKEINTRESOURCE(IDB_MIN)     );
	m_hMaxBtnBmp     = LoadBitmap( m_hInst, MAKEINTRESOURCE(IDB_MAX)     );
	m_hRestoreBtnBmp = LoadBitmap( m_hInst, MAKEINTRESOURCE(IDB_RESTORE) );
	m_hCloseBtnBmp   = LoadBitmap( m_hInst, MAKEINTRESOURCE(IDB_CLOSE)   );

	m_Loaded = TRUE;
}

void
FreeBitmap() {
	DeleteObject ( m_hLeftBmp       );
	DeleteObject ( m_hTopBmp        );
	DeleteObject ( m_hRightBmp      );
	DeleteObject ( m_hBottomBmp     );
	DeleteObject ( m_hMinBtnBmp     );
	DeleteObject ( m_hMaxBtnBmp     );
	DeleteObject ( m_hRestoreBtnBmp );
	DeleteObject ( m_hCloseBtnBmp   );

	DeleteObject ( m_hBtnMemBmp     );
	DeleteObject ( m_hBtnMaskBmp    );
	DeleteObject ( m_MemBitmap      );

	m_Loaded = FALSE;
}

void
skinWinFree()
{
	//release resource
	FreeBitmap();
	if (WindowText) {
		free( WindowText );
		WindowText = NULL;
	}

	if ( m_MemDC    ) DeleteDC ( m_MemDC    );
	if ( m_SkinDC   ) DeleteDC ( m_SkinDC   );
	if ( m_RegionDC ) DeleteDC ( m_RegionDC );

	if ( m_hFont ) DeleteObject( m_hFont );
}

BOOL
IsHandledMessage(UINT message)
{
	for (int i = 0; i < MESSAGE_COUNT; i++) {
		if (HANDLED_MESSAGE[i] == message)
			return TRUE;
	}

	return FALSE;
}

LRESULT
skinWndProc(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	switch(message)
	{
		case WM_SHOWWINDOW:
			if (wParam) {
				SetWindowPos(
				hWnd,
				HWND_TOP,
				0, 0, 500, 500,
				SWP_NOSIZE | SWP_NOMOVE | SWP_FRAMECHANGED | SWP_DRAWFRAME );
				DefWindowProc(hWnd, message, wParam, lParam);
			}
		break;

		case WM_INITMENUPOPUP:
			DefWindowProc(hWnd, message, wParam, lParam);
		break;

		case WM_SYSCOMMAND:
			OnSysCommand(hWnd, message, wParam, lParam);
		break;
		case WM_SETTEXT:
			OnSetText(hWnd, message, wParam, lParam);
		break;

		case WM_NCPAINT:
			OnNcPaint(hWnd, message, wParam, lParam);
		break;

		case WM_NCCALCSIZE:
			OnNcCalcSize(hWnd, message, wParam, lParam);
		break;

		case WM_SIZE:
			OnSize(hWnd, message, wParam, lParam);
		break;

		case WM_NCACTIVATE:
			OnNcActive(hWnd, message, wParam, lParam);
			break;
		case WM_NCHITTEST:
			return OnNcHitTest(hWnd, message, wParam, lParam);

		case WM_NCLBUTTONUP:
			OnNcLButtonUp(hWnd, message, wParam, lParam);
		break;

		case WM_NCLBUTTONDOWN:
			OnNcLButtonDown(hWnd, message, wParam, lParam);
			
			switch (m_mousedown) {
				case HTCLOSE:
					SendMessage(hWindow,WM_CLOSE,wParam,lParam);
					return 0;
				break;
				case HTMAXBUTTON:
					if (m_winstate == 1)
					RestoreWindow (); else
					MaximizeWindow();
				break;
				case HTMINBUTTON:
				break;
			}
			return 0;
		break;

		case WM_NCLBUTTONDBLCLK:
			OnNcLButtonDblClk(hWnd, message, wParam, lParam);
		break;

		case WM_NCRBUTTONUP:
			OnNcRButtonUp(hWnd, message, wParam, lParam);
		break;

		case WM_NCRBUTTONDOWN:
			OnNcRButtonDown(hWnd, message, wParam, lParam);
		break;

		case WM_NCMOUSEMOVE:
			OnNcMouseMove(hWnd, message, wParam, lParam);
		break;

		case WM_GETMINMAXINFO:
			OnGetMinMaxInfo(hWnd, message, wParam, lParam);
		break;

		case WM_WINDOWPOSCHANGING:
			OnWindowPosChanging(hWnd, message, wParam, lParam);
		break;

		case WM_SIZING:
			OnSizing(hWnd, message, wParam, lParam);
		break;

		case WM_ACTIVATE:
			OnActive(hWnd, message, wParam, lParam);
		break;

		default:
		break;
	}

	return 0;
}

void
OnNcPaint(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	//get device context(DC) of window
	HDC WindowDC = GetWindowDC(hWnd);

	//get rectangle of window, and calculate windows
	RECT WindowRect;
	GetWindowRect(hWnd, &WindowRect);

	//clip client's region, and tell system do not paint this region
	RECT ClientRect;
	GetClientRect(hWnd, &ClientRect);

	// window's width and height
	int width, height;
	// normal
	if (m_winstate == 1) {
		width  = WindowRect.right  - 1;
		height = WindowRect.bottom - 1;
	}
	// maximized
	else {
		width  = newWindowRectWidth;
		height = newWindowRectHeight;
	}

	if (m_MemBitmap) {
		SelectObject(m_MemDC, m_OldMemBitmap);
		DeleteObject(m_MemBitmap);
	}

	m_MemBitmap = CreateCompatibleBitmap(WindowDC, width, height);
	m_OldMemBitmap = (HBITMAP)SelectObject(m_MemDC, m_MemBitmap);

	int state = (IsActive==TRUE) ? 0 : 1;
	DrawFrame(m_MemDC, 0, 0, width, height, 1);

	//draw caption buttons
	DrawButton ( m_MemDC, 0, 0 ); // close button
	DrawButton ( m_MemDC, 1, 0 ); // max:
	DrawButton ( m_MemDC, 2, 0 ); // min:

	//draw icon
	HICON hi;
	int cx = GetSystemMetrics(SM_CXSMICON);
	int cy = GetSystemMetrics(SM_CYSMICON);
	hi = (HICON)SendMessage( m_hWnd, WM_GETICON, IDI_SMALL, 0);
	if(!hi) hi = LoadIcon(m_hInst, MAKEINTRESOURCE(IDI_DRAWWINDOW));

	//caution: use function CopyImage() will lead to GDI leak at here!!!
	//i took many times to find that call CopyImage will lead to GDI leak,
	//this function is so horrible.
	if(hi)
		DrawIconEx( m_MemDC, 10, 5, hi/*(HICON)CopyImage( hi, IMAGE_ICON, cx, cy, 0)*/,
		cx, cy, 0, 0, DI_NORMAL);

	//draw text
	if(!WindowText) WindowText = (char*)malloc(sizeof(char)*255);
	int len = GetWindowText(m_hWnd, WindowText, 255);

	RECT textRect;
	textRect.left = 30;
	textRect.top = 0;
	textRect.right = width - bmpTop.bmWidth + 40;
	textRect.bottom = BorderTopHeight;

	SetBkMode(m_MemDC, TRANSPARENT);
	SetTextColor(m_MemDC, IsActive ? RGB(255,255,255) : RGB(0, 0, 0));

	m_hOldFont = (HFONT)SelectObject(m_MemDC, m_hFont);
	DrawText(m_MemDC, WindowText, len, &textRect, DT_SINGLELINE | DT_LEFT | DT_VCENTER | DT_WORD_ELLIPSIS);
	SelectObject(m_MemDC, m_hOldFont);

	BitBlt(WindowDC, 0, 0, width, height, m_MemDC, 0, 0, SRCCOPY);
	SelectClipRgn(WindowDC, NULL);

	ReleaseDC(hWnd, WindowDC);
}

void
OnNcActive(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	IsActive = (BOOL)wParam;
	OnNcPaint(hWnd, message, wParam, lParam);
}

void
OnNcCalcSize(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	NCCALCSIZE_PARAMS* pParams = NULL;
	RECT* pRect = NULL;

	BOOL bValue = static_cast<BOOL>(wParam);
	if (bValue) pParams = reinterpret_cast<NCCALCSIZE_PARAMS*>(lParam);
	else pRect = reinterpret_cast<RECT*>(lParam);

	if(bValue)
		pRect = &pParams->rgrc[0];

	if (bValue) {
		pRect->left   = pRect->left   + bmpLeft.bmWidth/2;
		pRect->top    = pRect->top    + bmpTop.bmHeight/2;
		pRect->right  = pRect->right  - bmpRight.bmWidth/2;
		pRect->bottom = pRect->bottom - bmpBottom.bmHeight/2;

		pParams->rgrc[1] = pParams->rgrc[0];
	}
	else DefWindowProc(hWnd, message, wParam, lParam);
}

UINT OnNcHitTest(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{	
	POINT point;
	point.x = LOWORD(lParam);
	point.y = HIWORD(lParam);

	RECT WinRect, rect;
	GetWindowRect(hWnd, &WinRect);

	int width = WinRect.right-WinRect.left;
	int height = WinRect.bottom-WinRect.top;

	point.x -= WinRect.left;
	point.y -= WinRect.top;

	rect = GetButtonRect(0);
	if (PtInRect(&rect, point))
		return HTCLOSE;

	rect = GetButtonRect(2);
	if (PtInRect(&rect, point) && m_minable)
		return HTMINBUTTON;

	rect = GetButtonRect(1);
	if (PtInRect(&rect, point) && m_maxable)
		return HTMAXBUTTON;

	int cx = GetSystemMetrics(SM_CXSMICON);
	int cy = GetSystemMetrics(SM_CYSMICON);
	
	SetRect(&rect, BorderLeftWidth, 5, BorderLeftWidth + cx, cy + 5);
	if (PtInRect( &rect, point ))
		return HTSYSMENU;

	SetRect( &rect, 0, 0, BorderLeftWidth, BorderTopHeight );
	if ( PtInRect( &rect, point ) && m_sizable && m_winstate != 1 )  //!IsZoomed(m_hWnd) )
		return HTTOPLEFT;

	SetRect( &rect, width - BorderLeftWidth, 0,  width, BorderTopHeight  );
	if ( PtInRect( &rect, point ) && m_sizable && m_winstate != 1 )  //!IsZoomed(m_hWnd) )
		return HTTOPRIGHT;

	SetRect( &rect, 0, height - BorderBottomHeight, BorderLeftWidth, height );
	if ( PtInRect( &rect, point ) && m_sizable && m_winstate != 1 )  //!IsZoomed(m_hWnd) )
		return HTBOTTOMLEFT;

	SetRect( &rect, width-BorderRightWidth,height-BorderBottomHeight,  width, height );
	if ( PtInRect( &rect, point ) && m_sizable && m_winstate != 1 )  //!IsZoomed(m_hWnd) )
		return HTBOTTOMRIGHT;

	SetRect( &rect, 0, BorderTopHeight,  BorderLeftWidth, height-BorderBottomHeight  );
	if ( PtInRect( &rect, point ) && m_sizable && m_winstate != 1 )  //!IsZoomed(m_hWnd) )
		return HTLEFT;

	SetRect( &rect, width-BorderRightWidth, BorderTopHeight,  width, height-BorderBottomHeight  );
	if ( PtInRect( &rect, point ) && m_sizable && m_winstate != 1 )  //!IsZoomed(m_hWnd) )
		return HTRIGHT;

	SetRect( &rect, BorderLeftWidth, height-BorderBottomHeight, width-BorderRightWidth, height );
	if ( PtInRect( &rect, point ) && m_sizable && m_winstate != 1 )  //!IsZoomed(m_hWnd) )
		return HTBOTTOM;

	SetRect( &rect, BorderLeftWidth, 0,  width-BorderRightWidth, BorderBottomHeight );
	if ( PtInRect( &rect, point ) && m_sizable && m_winstate != 1 )  //!IsZoomed(m_hWnd) )
		return HTTOP;

	//set to border 5
	SetRect( &rect, BorderLeftWidth, 5 , width-BorderRightWidth, BorderTopHeight );
	if ( PtInRect( &rect, point ) )
		return HTCAPTION;

	return HTCLIENT;
}

void
OnNcLButtonUp(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	if ( wParam == HTCLOSE ) {
		SendMessage(hWnd, WM_CLOSE, 0, 0);
		return;
	}
	else if( wParam == HTMINBUTTON)
		MinimizeWindow();
	else if( wParam == HTMAXBUTTON) {
		if ( m_winstate == 1)
			RestoreWindow();
		else
			MaximizeWindow();
	}
	else {
		OnNcPaint(hWnd, message, wParam, lParam);
		return;
	}

	m_downHitTest = 0;
	m_moveHitTest = 0;
	m_mousedown = 0;
	OnNcPaint(hWnd, message, wParam, lParam);
}

void
OnNcLButtonDown(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	RECT WindowRect;
	GetWindowRect(hWnd, &WindowRect);
		
	POINT point;
	point.x = LOWORD(lParam);
	point.y = HIWORD(lParam);
	
	int ButtonY = point.y - WindowRect.top;
	int ButtonX = WindowRect.right - point.x;

	m_mousedown = 0;

	// window caption buttons:
	if ((ButtonY >= 5) && (ButtonY <= 20)) {
		// min
		if ((ButtonX >= 55) && (ButtonX <= 74)) {
			m_mousedown = HTMINBUTTON;
			return;
		}	else
		
		// max
		if ((ButtonX >= 35) && (ButtonX <= 54)) {
			m_mousedown = HTMAXBUTTON;
			return;
		}	else
		
		// close
		if ((ButtonX >= 15) && (ButtonX <= 34)) {
			m_mousedown = HTCLOSE;
			return;
		}
	}
}

void
OnNcLButtonDblClk(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	RECT WindowRect;
	GetWindowRect(hWnd, &WindowRect);
		
	POINT point;
	point.x = LOWORD(lParam);
	point.y = HIWORD(lParam);
	
	int ButtonY = point.y - WindowRect.top;
	int ButtonX = WindowRect.right - point.x;

	m_mousedown = 0;

	// window title bar:
	if ((ButtonY >= 10) && (ButtonY <= 25)) {
		if ((ButtonX >= 4) && (ButtonX <= WindowRect.right - 4)) {
			if (m_winstate == 1)
			RestoreWindow (); else
			MaximizeWindow();
			OnNcPaint(hWnd, message, wParam, lParam);
		}
	}
}

void
OnNcMouseMove(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	if ( wParam >= HTLEFT && wParam <= HTBOTTOMRIGHT || 
		 wParam == HTCAPTION && m_winstate != 1 )  //!IsZoomed(m_hWnd) )
		DefWindowProc(hWnd, message, wParam, lParam);
	
	m_moveHitTest = (UINT)wParam;
	m_downHitTest = 0;

	if ( m_oldHitTest != wParam ) {
		OnNcPaint(hWnd, message, wParam, lParam);
		m_oldHitTest = (UINT)wParam;
	}
}

void
OnNcRButtonUp(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam) {
}

RECT
GetButtonRect(int index)
{
	//get rectangle of window
	RECT WindowRect, rect;
	GetWindowRect(m_hWnd, &WindowRect);

	//close button rect
	if(index == 0 && m_hCloseBtnBmp) {
		rect = closeBtnRect;
		rect.left = WindowRect.right - WindowRect.left - closeBtnRect.right;
		rect.right = WindowRect.right - WindowRect.left - closeBtnRect.left;
	}

	//max or restore button rect
	if(index == 1 && m_hMaxBtnBmp && m_hRestoreBtnBmp) {
		//max
		if(m_winstate != 1) {
			rect = maxBtnRect;
			rect.left = WindowRect.right - WindowRect.left - maxBtnRect.right;
			rect.right = WindowRect.right - WindowRect.left - maxBtnRect.left;
		}
		//restore
		else {
			rect = restoreBtnRect;
			rect.left = WindowRect.right - WindowRect.left - restoreBtnRect.right;
			rect.right = WindowRect.right - WindowRect.left - restoreBtnRect.left;
		}
	}

	//min button rect
	if(index == 2 && m_hMinBtnBmp) {
		rect = minBtnRect;
		rect.left = WindowRect.right - WindowRect.left - minBtnRect.right;
		rect.right = WindowRect.right - WindowRect.left - minBtnRect.left;
	}

	return rect;
}

void
OnSize(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	RECT rect;
	GetWindowRect(hWnd, &rect);

	InvalidateRect(hWnd, NULL, TRUE);
	OnNcPaint(hWnd, message, wParam, lParam);

	if ( m_bTrans ) {
		HDC WinDC = GetWindowDC(hWnd);
		HRGN rgn = GetRegion(WinDC, rect.right-rect.left, rect.bottom-rect.top );
		SetWindowRgn( m_hWnd, rgn, TRUE );
		DeleteObject(rgn);
		ReleaseDC(hWnd, WinDC);
	}
	else SetWindowRgn( m_hWnd, NULL, TRUE );
}

void
OnSizing(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	OnNcPaint(hWnd, message, wParam, lParam);
	//do nothing
}

void
OnActive(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	IsActive = TRUE; //( wParam == WA_ACTIVE || wParam == WA_CLICKACTIVE );
	OnNcPaint(hWnd, message, wParam, lParam);
}

void
OnWindowPosChanging(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	IsActive = TRUE;
	OnNcPaint(hWnd, message, wParam, lParam);
	DefWindowProc(hWnd, message, wParam, lParam);
}

void
OnGetMinMaxInfo(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	MINMAXINFO *lpMMI = (MINMAXINFO *)lParam;

	POINT point;
	point.x = bmpTop.bmWidth + bmpLeft.bmWidth + bmpRight.bmWidth;
	point.y = bmpTop.bmHeight + 20;

	lpMMI->ptMinTrackSize = point;
}

void
OnSetText(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	WindowText = (char*)lParam;

	DefWindowProc (hWnd, message, wParam, lParam);
	OnNcPaint     (hWnd, message, wParam, lParam);
}

void 
OnSysCommand(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	if ( wParam == SC_MAXIMIZE )
		MaximizeWindow();
	else if ( wParam == SC_RESTORE && m_winstate == 1 )
		RestoreWindow();
	else if ( wParam == SC_RESTORE && m_winstate == 2 ) {
		ShowWindow( m_hWnd, SW_RESTORE );
		m_winstate = m_oldwinstate;
		OnNcPaint(hWnd, message, wParam, lParam);
	}
	else
		DefWindowProc(hWnd, message, wParam, lParam);
}

void
OnNcRButtonDown(
	HWND hWnd,
	UINT message,
	WPARAM wParam,
	LPARAM lParam)
{
	if( wParam == HTCAPTION) {
		POINT point;
		point.x = LOWORD(lParam);
		point.y = HIWORD(lParam);

		HMENU hMenu = GetSystemMenu(m_hWnd, FALSE);

		if(hMenu)
			TrackPopupMenu(hMenu, TPM_LEFTALIGN, point.x, point.y, 0, m_hWnd, NULL);
	}
}

void
DrawFrame(
	HDC hDc,
	int x,
	int y,
	int width,
	int height,
	int state)
{
	DrawLeft(hDc, x, y, height, state);
	DrawTitle(hDc, x + BorderLeftWidth, y,
		width - BorderRightWidth - BorderLeftWidth + 1, state);
	DrawRight(hDc, x + width - BorderRightWidth, y, height, state);
	DrawBottom(hDc, x + BorderLeftWidth, y + height - BorderBottomHeight,
		width - BorderRightWidth - BorderLeftWidth, state);
}

void
DrawTitle(
	HDC hDc,
	int x,
	int y,
	int width,
	int state)
{
	RECT rect;

	int padding = ( width - bmpTop.bmWidth )/( TopOffset2 - TopOffset1 ) + 1 ;
	if ( padding < 0 ) padding = 0;
	int ox = x;

	m_OldSkinBitmap = (HBITMAP)SelectObject(m_SkinDC, m_hTopBmp);

	//lefttop
	if(state == 0) {
		rect.left = 0;
		rect.top = 0;
		rect.right = TopOffset1;
		rect.bottom = BorderTopHeight;
	}
	else {
		rect.left = 0;
		rect.top = BorderTopHeight;
		rect.right = TopOffset1;
		rect.bottom = bmpTop.bmHeight;
	}

	BitBlt(hDc, x, y, rect.right-rect.left, rect.bottom-rect.top,
		m_SkinDC, rect.left, rect.top, SRCCOPY);
	

	//middle
	x += LeftOffset1;
	if(state == 0) {
		rect.left = TopOffset1;
		rect.top = 0;
		rect.right = TopOffset2;
		rect.bottom = BorderTopHeight;
	}
	else {
		rect.left = TopOffset1;
		rect.top = BorderTopHeight;
		rect.right = TopOffset2;
		rect.bottom = bmpTop.bmHeight;
	}

	for(int i=x;i<width-TopOffset2;i++) {
		BitBlt(hDc, i, y, rect.right-rect.left, rect.bottom-rect.top,
			m_SkinDC, rect.left, rect.top, SRCCOPY);
	}

	//righttop
	x = ox + width - ( bmpTop.bmWidth - TopOffset2 );
	if(state == 0) {
		rect.left = TopOffset2;
		rect.top = 0;
		rect.right = bmpTop.bmWidth-1;
		rect.bottom = BorderTopHeight;
	}
	else {
		rect.left = TopOffset2;
		rect.top = BorderTopHeight;
		rect.right = bmpTop.bmWidth-1;
		rect.bottom = bmpTop.bmHeight;
	}

	BitBlt(hDc, x, y, rect.right-rect.left, rect.bottom-rect.top,
		m_SkinDC, rect.left, rect.top, SRCCOPY);

	SelectObject(m_SkinDC, m_OldSkinBitmap);
}

void
DrawLeft(
	HDC hDc,
	int x,
	int y,
	int height,
	int state)
{
	RECT rect;

	int padding = (height - bmpLeft.bmHeight) / (LeftOffset2 - LeftOffset1) + 1;
	if(padding < 0) padding = 0;
	int oy = y;

	m_OldSkinBitmap = (HBITMAP)SelectObject(m_SkinDC, m_hLeftBmp);

	//topleft
	if(state == 0) {
		rect.left = 0;
		rect.top = 0;
		rect.right = bmpLeft.bmWidth/2;
		rect.bottom = LeftOffset1;
	}
	else {
		rect.left = bmpLeft.bmWidth/2;
		rect.top = 0;
		rect.right = bmpLeft.bmWidth;
		rect.bottom = LeftOffset1;
	}

	BitBlt(hDc, x, y, rect.right-rect.left, rect.bottom-rect.top,
		m_SkinDC, rect.left, rect.top, SRCCOPY);

	//middle
	y += LeftOffset1;
	if(state == 0) {
		rect.left = 0;
		rect.top = LeftOffset1;
		rect.right = BorderLeftWidth;
		rect.bottom = LeftOffset2;
	}
	else {
		rect.left = BorderLeftWidth;
		rect.top = LeftOffset1;
		rect.right = bmpLeft.bmWidth;
		rect.bottom = LeftOffset2;
	}

	for(int i = 0; i <= padding; i++, y += LeftOffset2 - LeftOffset1) {
		int d = ( y + LeftOffset2 - LeftOffset1 - oy - height);
		if ( d > 0 )
			rect.bottom = rect.bottom - d;

		BitBlt(hDc, x, y, rect.right-rect.left, rect.bottom-rect.top,
			m_SkinDC, rect.left, rect.top, SRCCOPY);
	}

	//bottomleft
	y = oy + height - (bmpLeft.bmHeight - LeftOffset2);
	if(state == 0) {
		rect.left = 0;
		rect.top = LeftOffset2;
		rect.right = BorderLeftWidth;
		rect.bottom = bmpLeft.bmHeight;
	}
	else {
		rect.left = BorderLeftWidth;
		rect.top = LeftOffset2;
		rect.right = bmpLeft.bmWidth;
		rect.bottom = bmpLeft.bmHeight;
	}

	BitBlt(hDc, x, y, rect.right-rect.left, rect.bottom-rect.top,
			m_SkinDC, rect.left, rect.top, SRCCOPY);

	SelectObject(m_SkinDC, m_OldSkinBitmap);
}

void
DrawRight(
	HDC hDc,
	int x,
	int y,
	int height,
	int state)
{
	RECT rect;

	int padding = (height - bmpRight.bmHeight) / (RightOffset2 - RightOffset1) + 1;
	if(padding < 0) padding = 0;
	int oy = y;

	m_OldSkinBitmap = (HBITMAP)SelectObject(m_SkinDC, m_hRightBmp);

	//topleft
	if(state == 0) {
		rect.left = 0;
		rect.top = 0;
		rect.right = bmpRight.bmWidth/2;
		rect.bottom = RightOffset1;
	}
	else {
		rect.left = bmpRight.bmWidth/2;
		rect.top = 0;
		rect.right = bmpRight.bmWidth;
		rect.bottom = RightOffset1;
	}

	BitBlt(hDc, x, y, rect.right-rect.left, rect.bottom-rect.top,
		m_SkinDC, rect.left, rect.top, SRCCOPY);

	//middle
	y += LeftOffset1;
	if(state == 0) {
		rect.left = 0;
		rect.top = RightOffset1;
		rect.right = BorderLeftWidth;
		rect.bottom = RightOffset2;
	}
	else {
		rect.left = BorderLeftWidth;
		rect.top = RightOffset1;
		rect.right = bmpRight.bmWidth;
		rect.bottom = RightOffset2;
	}

	for(int i = 0; i <= padding; i++, y += RightOffset2 - RightOffset1) {
		int d = ( y + RightOffset2 - RightOffset1 - oy - height);
		if ( d > 0 )
			rect.bottom = rect.bottom - d;

		BitBlt(hDc, x, y, rect.right-rect.left, rect.bottom-rect.top,
			m_SkinDC, rect.left, rect.top, SRCCOPY);
	}

	//bottomleft
	y = oy + height - (bmpRight.bmHeight - RightOffset2);
	if(state == 0) {
		rect.left = 0;
		rect.top = RightOffset2;
		rect.right = BorderLeftWidth;
		rect.bottom = bmpRight.bmHeight;
	}
	else {
		rect.left = BorderLeftWidth;
		rect.top = RightOffset2;
		rect.right = bmpRight.bmWidth;
		rect.bottom = bmpRight.bmHeight;
	}

	BitBlt(hDc, x, y, rect.right-rect.left, rect.bottom-rect.top,
			m_SkinDC, rect.left, rect.top, SRCCOPY);

	SelectObject(m_SkinDC, m_OldSkinBitmap);
}

void
DrawBottom(
	HDC hDc,
	int x,
	int y,
	int width,
	int state)
{
	RECT rect;

	int padding = ( width - bmpBottom.bmWidth )/( BottomOffset2 - BottomOffset1 ) + 1 ;
	if ( padding < 0 ) padding = 0;
	int ox = x;

	m_OldSkinBitmap = (HBITMAP)SelectObject(m_SkinDC, m_hBottomBmp);

	//leftbottom
	if(state == 0) {
		rect.left = 0;
		rect.top = 0;
		rect.right = BottomOffset1;
		rect.bottom = BorderBottomHeight;
	}
	else {
		rect.left = 0;
		rect.top = BorderBottomHeight;
		rect.right = BottomOffset1;
		rect.bottom = bmpBottom.bmHeight;
	}

	BitBlt(hDc, x, y, rect.right-rect.left, rect.bottom-rect.top,
		m_SkinDC, rect.left, rect.top, SRCCOPY);

	//middle
	x += BottomOffset1;
	if(state == 0) {
		rect.left = BottomOffset1;
		rect.top = 0;
		rect.right = BottomOffset2;
		rect.bottom = BorderBottomHeight;
	}
	else {
		rect.left = BottomOffset1;
		rect.top = BorderBottomHeight;
		rect.right = BottomOffset2;
		rect.bottom = bmpBottom.bmHeight;
	}

	for(int i = 0; i <= padding; i++, x += BottomOffset2 - BottomOffset1) {
		int d = ( x + BottomOffset2 - BottomOffset1 - ox - width);
		if ( d > 0 )
			rect.right = rect.right - d;

		BitBlt(hDc, x, y, rect.right-rect.left, rect.bottom-rect.top,
			m_SkinDC, rect.left, rect.top, SRCCOPY);
	}

	//rightbottom
	x = ox + width - ( bmpBottom.bmWidth - BottomOffset2 );
	if(state == 0) {
		rect.left = BottomOffset2;
		rect.top = 0;
		rect.right = bmpBottom.bmWidth-1;
		rect.bottom = BorderBottomHeight;
	}
	else {
		rect.left = BottomOffset2;
		rect.top = BorderBottomHeight;
		rect.right = bmpBottom.bmWidth-1;
		rect.bottom = bmpBottom.bmHeight;
	}

	BitBlt(hDc, x, y, rect.right-rect.left, rect.bottom-rect.top,
		m_SkinDC, rect.left, rect.top, SRCCOPY);

	SelectObject(m_SkinDC, m_OldSkinBitmap);
}

BOOL
DrawButton(
	HDC hDc,
	int index,
	int state)
{
	//get button's rect
	RECT rect, sr;
	rect = GetButtonRect(index);

	//close button
	if(index == 0 && m_hCloseBtnBmp) {
		sr.left = state * (rect.right-rect.left);
		sr.top = 0;
		sr.right = (state+1) * (rect.right-rect.left);
		sr.bottom = bmpCloseBtn.bmHeight;

		MyTransparentBlt(hDc, rect.left, rect.top, sr.right-sr.left,
			sr.bottom-sr.top, m_hCloseBtnBmp, sr.left, sr.top, clrTrans, NULL);
	}

	if(index == 1 && m_hMaxBtnBmp && m_hRestoreBtnBmp) {
		sr.left = state * (rect.right-rect.left);
		sr.top = 0;
		sr.right = (state+1) * (rect.right-rect.left);
		sr.bottom = bmpCloseBtn.bmHeight;

		if(m_winstate == 1)
			MyTransparentBlt(hDc, rect.left, rect.top, sr.right-sr.left,
				sr.bottom-sr.top, m_hRestoreBtnBmp, sr.left, sr.top, clrTrans, NULL);
		else
			MyTransparentBlt(hDc, rect.left, rect.top, sr.right-sr.left,
				sr.bottom-sr.top, m_hMaxBtnBmp, sr.left, sr.top, clrTrans, NULL);
	}

	if(index == 2 && m_hMinBtnBmp) {
		sr.left = state * (rect.right-rect.left);
		sr.top = 0;
		sr.right = (state+1) * (rect.right-rect.left);
		sr.bottom = bmpCloseBtn.bmHeight;

		MyTransparentBlt(hDc, rect.left, rect.top, sr.right-sr.left,
			sr.bottom-sr.top, m_hMinBtnBmp, sr.left, sr.top, clrTrans, NULL);
	}

	return TRUE;
}

HRGN
CreateRgnFromColor(
	HBITMAP hBmp,
	COLORREF color)
{
	// get image properties
	BITMAP bmp = { 0 };
	GetObject( hBmp, sizeof(BITMAP), &bmp );
	// allocate memory for extended image information
	LPBITMAPINFO bi = (LPBITMAPINFO) new BYTE[ sizeof(BITMAPINFO) + 8 ];
	memset( bi, 0, sizeof(BITMAPINFO) + 8 );
	bi->bmiHeader.biSize = sizeof(BITMAPINFOHEADER);
	// set window size
	int m_dwWidth	= bmp.bmWidth;		// bitmap width
	int m_dwHeight	= bmp.bmHeight;		// bitmap height
	// create temporary dc
	HDC dc = CreateIC( "DISPLAY", NULL, NULL, NULL );
	// get extended information about image (length, compression, length of color table if exist, ...)
	DWORD res = GetDIBits( dc, hBmp, 0, bmp.bmHeight, 0, bi, DIB_RGB_COLORS );
	// allocate memory for image data (colors)
	LPBYTE pBits = new BYTE[ bi->bmiHeader.biSizeImage + 4 ];
	// allocate memory for color table
	if ( bi->bmiHeader.biBitCount == 8 )
	{
		// actually color table should be appended to this header(BITMAPINFO),
		// so we have to reallocate and copy it
		LPBITMAPINFO old_bi = bi;
		// 255 - because there is one in BITMAPINFOHEADER
		bi = (LPBITMAPINFO)new char[ sizeof(BITMAPINFO) + 255 * sizeof(RGBQUAD) ];
		memcpy( bi, old_bi, sizeof(BITMAPINFO) );
		// release old header
		delete old_bi;
	}
	// get bitmap info header
	BITMAPINFOHEADER& bih = bi->bmiHeader;
	// get color table (for 256 color mode contains 256 entries of RGBQUAD(=DWORD))
	LPDWORD clr_tbl = (LPDWORD)&bi->bmiColors;
	// fill bits buffer
	res = GetDIBits( dc, hBmp, 0, bih.biHeight, pBits, bi, DIB_RGB_COLORS );
	DeleteDC( dc );

	BITMAP bm;
	::GetObject( hBmp, sizeof(BITMAP), &bm );
	// shift bits and byte per pixel (for comparing colors)
	LPBYTE pClr = (LPBYTE)&color;
	// swap red and blue components
	BYTE tmp = pClr[0]; pClr[0] = pClr[2]; pClr[2] = tmp;
	// convert color if curent DC is 16-bit (5:6:5) or 15-bit (5:5:5)
	if ( bih.biBitCount == 16 )
	{
		// for 16 bit
		color = ((DWORD)(pClr[0] & 0xf8) >> 3) |
				((DWORD)(pClr[1] & 0xfc) << 3) |
				((DWORD)(pClr[2] & 0xf8) << 8);
		// for 15 bit
//		color = ((DWORD)(pClr[0] & 0xf8) >> 3) |
//				((DWORD)(pClr[1] & 0xf8) << 2) |
//				((DWORD)(pClr[2] & 0xf8) << 7);
	}

	const DWORD RGNDATAHEADER_SIZE	= sizeof(RGNDATAHEADER);
	const DWORD ADD_RECTS_COUNT		= 40;			// number of rects to be appended
													// to region data buffer

	// BitPerPixel
	BYTE	Bpp = bih.biBitCount >> 3;				// bytes per pixel
	// bytes per line in pBits is DWORD aligned and bmp.bmWidthBytes is WORD aligned
	// so, both of them not
	DWORD m_dwAlignedWidthBytes = (bmp.bmWidthBytes & ~0x3) + (!!(bmp.bmWidthBytes & 0x3) << 2);
	// DIB image is flipped that's why we scan it from the last line
	LPBYTE	pColor = pBits + (bih.biHeight - 1) * m_dwAlignedWidthBytes;
	DWORD	dwLineBackLen = m_dwAlignedWidthBytes + bih.biWidth * Bpp;	// offset of previous scan line
													// (after processing of current)
	DWORD	dwRectsCount = bih.biHeight;			// number of rects in allocated buffer
	INT		i, j;									// current position in mask image
	INT		first = 0;								// left position of current scan line
													// where mask was found
	bool	wasfirst = false;						// set when mask has been found in current scan line
	bool	ismask;									// set when current color is mask color

	// allocate memory for region data
	// region data here is set of regions that are rectangles with height 1 pixel (scan line)
	// that's why first allocation is <bm.biHeight> RECTs - number of scan lines in image
	RGNDATAHEADER* pRgnData = 
		(RGNDATAHEADER*)new BYTE[ RGNDATAHEADER_SIZE + dwRectsCount * sizeof(RECT) ];
	// get pointer to RECT table
	LPRECT pRects = (LPRECT)((LPBYTE)pRgnData + RGNDATAHEADER_SIZE);
	// zero region data header memory (header  part only)
	memset( pRgnData, 0, RGNDATAHEADER_SIZE + dwRectsCount * sizeof(RECT) );
	// fill it by default
	pRgnData->dwSize	= RGNDATAHEADER_SIZE;
	pRgnData->iType		= RDH_RECTANGLES;

	for ( i = 0; i < bih.biHeight; i++ )
	{
		for ( j = 0; j < bih.biWidth; j++ )
		{
			// get color
			switch ( bih.biBitCount )
			{
			case 8:
				ismask = (clr_tbl[ *pColor ] != color);
				break;
			case 16:
				ismask = (*(LPWORD)pColor != (WORD)color);
				break;
			case 24:
				ismask = ((*(LPDWORD)pColor & 0x00ffffff) != color);
				break;
			case 32:
				ismask = (*(LPDWORD)pColor != color);
			}
			// shift pointer to next color
			pColor += Bpp;
			// place part of scan line as RECT region if transparent color found after mask color or
			// mask color found at the end of mask image
			if ( wasfirst )
			{
				if ( !ismask )
				{
					// save current RECT
					RECT rect1;
					SetRect(&rect1,first, i, j, i + 1);
					pRects[ pRgnData->nCount++ ] = rect1;
					// if buffer full reallocate it with more room
					if ( pRgnData->nCount >= dwRectsCount )
					{
						dwRectsCount += ADD_RECTS_COUNT;
						// allocate new buffer
						LPBYTE pRgnDataNew = new BYTE[ RGNDATAHEADER_SIZE + dwRectsCount * sizeof(RECT) ];
						// copy current region data to it
						memcpy( pRgnDataNew, pRgnData, RGNDATAHEADER_SIZE + pRgnData->nCount * sizeof(RECT) );
						// delte old region data buffer
						delete pRgnData;
						// set pointer to new regiondata buffer to current
						pRgnData = (RGNDATAHEADER*)pRgnDataNew;
						// correct pointer to RECT table
						pRects = (LPRECT)((LPBYTE)pRgnData + RGNDATAHEADER_SIZE);
					}
					wasfirst = false;
				}
			}
			else if ( ismask )		// set wasfirst when mask is found
			{
				first = j;
				wasfirst = true;
			}
		}

		if ( wasfirst && ismask )
		{
			// save current RECT
			RECT rect2;
			SetRect(&rect2, first, i, j, i + 1);
			pRects[ pRgnData->nCount++ ] = rect2;
			// if buffer full reallocate it with more room
			if ( pRgnData->nCount >= dwRectsCount )
			{
				dwRectsCount += ADD_RECTS_COUNT;
				// allocate new buffer
				LPBYTE pRgnDataNew = new BYTE[ RGNDATAHEADER_SIZE + dwRectsCount * sizeof(RECT) ];
				// copy current region data to it
				memcpy( pRgnDataNew, pRgnData, RGNDATAHEADER_SIZE + pRgnData->nCount * sizeof(RECT) );
				// delte old region data buffer
				delete pRgnData;
				// set pointer to new regiondata buffer to current
				pRgnData = (RGNDATAHEADER*)pRgnDataNew;
				// correct pointer to RECT table
				pRects = (LPRECT)((LPBYTE)pRgnData + RGNDATAHEADER_SIZE);
			}
			wasfirst = false;
		}

		pColor -= dwLineBackLen;
	}
	// release image data
	delete pBits;
	delete bi;

	// create region
	HRGN hRgn = ExtCreateRegion( NULL, RGNDATAHEADER_SIZE + pRgnData->nCount * sizeof(RECT), (LPRGNDATA)pRgnData );
	// release region data
	delete pRgnData;

	return hRgn;
}

HRGN
GetRegion(
	HDC hDc,
	int width,
	int height)
{
	HBITMAP hBmp = CreateCompatibleBitmap(hDc, width, BorderTopHeight);
	HBITMAP hOldBmp = (HBITMAP)SelectObject(m_RegionDC, hBmp);

	DrawTitle( m_RegionDC, BorderLeftWidth , 0, 
		width - BorderRightWidth - BorderLeftWidth + 1, 0 );
	DrawLeft( m_RegionDC, 0, 0, bmpLeft.bmHeight, 0 );
	DrawRight( m_RegionDC, width - BorderRightWidth , 0, bmpRight.bmHeight, 0 );

	HRGN rgn, hrgn, newrgn;
	rgn = CreateRectRgn(0, BorderTopHeight, width, height);
	hrgn = CreateRegionFromBitmap(hBmp, clrTrans);
	newrgn = CreateRectRgn(0, BorderTopHeight, width, height);
	CombineRgn(newrgn, rgn, hrgn, RGN_XOR);

	SelectObject(m_RegionDC, hOldBmp);

	DeleteObject(hBmp);
	DeleteObject(hrgn);
	DeleteObject(rgn);

	return newrgn;
}

RECT
GetMaximizeRect()
{
	RECT rect;
	SystemParametersInfo(SPI_GETWORKAREA, 0, (PVOID)&rect, 0);
	return rect;
}

BOOL
MaximizeWindow()
{
	RECT r = GetMaximizeRect();
	
	oldWindowRectWidth  = newWindowRectWidth;
	oldWindowRectHeight = newWindowRectHeight;
	
	GetWindowRect( m_hWnd, &RestoreWinRect );

	m_winstate = 1;
	MoveWindow( m_hWnd, r.left, r.top, r.right-r.left, r.bottom-r.top, TRUE  );
	UpdateWindow( m_hWnd );

	IsActive = TRUE;
	return TRUE;
}


BOOL
MinimizeWindow()
{
	m_oldwinstate = m_winstate;
	m_winstate = 2;
	ShowWindow(m_hWnd, SW_MINIMIZE);
	return TRUE;
}


BOOL
RestoreWindow()
{
	if ( m_winstate == 1 ) {
		MoveWindow( m_hWnd, RestoreWinRect.left, RestoreWinRect.top,
			RestoreWinRect.right-RestoreWinRect.left, RestoreWinRect.bottom-RestoreWinRect.top, TRUE  );
		m_winstate = 0;
		UpdateWindow( m_hWnd );
	}

	return TRUE;
}

HRGN
CreateRegionFromBitmap(
	HBITMAP hBitmap,
	COLORREF transparentColor)
{
	HRGN hRgn = NULL;
	HRGN hRgn1 = NULL;

	// Check for valid bitmap handle
	if ( hBitmap != NULL ) {
		// Get bitmap object information
		BITMAP bitmap;
		GetObject(hBitmap, sizeof(BITMAP), &bitmap);
		DWORD dwSize = bitmap.bmHeight * bitmap.bmWidthBytes;
		int bitsPixel = bitmap.bmBitsPixel / 8;

		// Check bitmap color depth (only 24 or 32 bits per pixel allowed)
		if ( ( bitsPixel == 3 ) || ( bitsPixel == 4 ) ) {
			// Get bitmap bits
			unsigned char* pBits = new unsigned char[dwSize];
			GetBitmapBits(hBitmap, dwSize, pBits);

			// Create region from bitmap
			unsigned char red, green, blue;
			for ( int y=0; y<bitmap.bmHeight; y++ ) {
				for ( int x=0; x<bitmap.bmWidth; x++ ) {
					// Get pixel color
					blue = pBits[y*bitmap.bmWidthBytes + bitsPixel*x];
					green = pBits[y*bitmap.bmWidthBytes + bitsPixel*x+1];
					red = pBits[y*bitmap.bmWidthBytes + bitsPixel*x+2];

					// Check transparent color
					if ( RGB(red,green,blue) != transparentColor ) {
						// Combine regions
						if ( hRgn == NULL )
							hRgn = CreateRectRgn(x, y, x+1, y+1);
						else {
							// Delete temporary region
							if ( hRgn1 != NULL )
								DeleteObject(hRgn1);

							// Create temporary region
							hRgn1 = CreateRectRgn(x, y, x+1, y+1);

							// Combine regions
							CombineRgn(hRgn, hRgn, hRgn1, RGN_OR);
						}
					}
				}
			}

			// Free bitmap bits
			delete pBits;
		}
	}

	// Delete temporary region
	if ( hRgn1 != NULL )
		DeleteObject(hRgn1);

	return hRgn;
}

HRGN 
BitmapToRegion(
	HBITMAP hBmp,
	COLORREF cTransparentColor,
	COLORREF cTolerance)
{
	HRGN hRgn = NULL;

	if (hBmp) {
		// Create a memory DC inside which we will scan the bitmap content
		HDC hMemDC = CreateCompatibleDC(NULL);
		if (hMemDC) {
			// Get bitmap size
			BITMAP bm;
			GetObject(hBmp, sizeof(bm), &bm);

			// Create a 32 bits depth bitmap and select it into the memory DC 
			BITMAPINFOHEADER RGB32BITSBITMAPINFO = {	
				sizeof(BITMAPINFOHEADER),	// biSize 
				bm.bmWidth,					// biWidth; 
				bm.bmHeight,				// biHeight; 
				1,							// biPlanes; 
				32,							// biBitCount 
				BI_RGB,						// biCompression; 
				0,							// biSizeImage; 
				0,							// biXPelsPerMeter; 
				0,							// biYPelsPerMeter; 
				0,							// biClrUsed; 
				0							// biClrImportant; 
			};

			VOID * pbits32; 
			HBITMAP hbm32 = CreateDIBSection(hMemDC, (BITMAPINFO *)&RGB32BITSBITMAPINFO, DIB_RGB_COLORS, &pbits32, NULL, 0);
			if (hbm32) {
				HBITMAP holdBmp = (HBITMAP)SelectObject(hMemDC, hbm32);

				// Create a DC just to copy the bitmap into the memory DC
				HDC hDC = CreateCompatibleDC(hMemDC);
				if (hDC) {
					// Get how many bytes per row we have for the bitmap bits (rounded up to 32 bits)
					BITMAP bm32;
					GetObject(hbm32, sizeof(bm32), &bm32);
					while (bm32.bmWidthBytes % 4)
						bm32.bmWidthBytes++;

					// Copy the bitmap into the memory DC
					HBITMAP holdBmp = (HBITMAP)SelectObject(hDC, hBmp);
					BitBlt(hMemDC, 0, 0, bm.bmWidth, bm.bmHeight, hDC, 0, 0, SRCCOPY);

					// For better performances, we will use the ExtCreateRegion() function to create the
					// region. This function take a RGNDATA structure on entry. We will add rectangles by
					// amount of ALLOC_UNIT number in this structure.
					#define ALLOC_UNIT	100
					DWORD maxRects = ALLOC_UNIT;
					HANDLE hData = GlobalAlloc(GMEM_MOVEABLE, sizeof(RGNDATAHEADER) + (sizeof(RECT) * maxRects));
					RGNDATA *pData = (RGNDATA *)GlobalLock(hData);
					pData->rdh.dwSize = sizeof(RGNDATAHEADER);
					pData->rdh.iType = RDH_RECTANGLES;
					pData->rdh.nCount = pData->rdh.nRgnSize = 0;
					SetRect(&pData->rdh.rcBound, MAXLONG, MAXLONG, 0, 0);

					// Keep on hand highest and lowest values for the "transparent" pixels
					BYTE lr = GetRValue(cTransparentColor);
					BYTE lg = GetGValue(cTransparentColor);
					BYTE lb = GetBValue(cTransparentColor);
					BYTE hr = std::min(0xff, lr + GetRValue(cTolerance));
					BYTE hg = std::min(0xff, lg + GetGValue(cTolerance));
					BYTE hb = std::min(0xff, lb + GetBValue(cTolerance));

					// Scan each bitmap row from bottom to top (the bitmap is inverted vertically)
					BYTE *p32 = (BYTE *)bm32.bmBits + (bm32.bmHeight - 1) * bm32.bmWidthBytes;
					for (int y = 0; y < bm.bmHeight; y++) {
						// Scan each bitmap pixel from left to right
						for (int x = 0; x < bm.bmWidth; x++) {
							// Search for a continuous range of "non transparent pixels"
							int x0 = x;
							LONG *p = (LONG *)p32 + x;
							while (x < bm.bmWidth) {
								BYTE b = GetRValue(*p);
								if (b >= lr && b <= hr) {
									b = GetGValue(*p);
									if (b >= lg && b <= hg) {
										b = GetBValue(*p);
										if (b >= lb && b <= hb)
											// This pixel is "transparent"
											break;
									}
								}
								p++;
								x++;
							}

							if (x > x0) {
								// Add the pixels (x0, y) to (x, y+1) as a new rectangle in the region
								if (pData->rdh.nCount >= maxRects) {
									GlobalUnlock(hData);
									maxRects += ALLOC_UNIT;
									hData = GlobalReAlloc(hData, sizeof(RGNDATAHEADER) + (sizeof(RECT) * maxRects), GMEM_MOVEABLE);
									pData = (RGNDATA *)GlobalLock(hData);
								}

								RECT *pr = (RECT *)&pData->Buffer;
								SetRect(&pr[pData->rdh.nCount], x0, y, x, y+1);
								if (x0 < pData->rdh.rcBound.left)
									pData->rdh.rcBound.left = x0;
								if (y < pData->rdh.rcBound.top)
									pData->rdh.rcBound.top = y;
								if (x > pData->rdh.rcBound.right)
									pData->rdh.rcBound.right = x;
								if (y+1 > pData->rdh.rcBound.bottom)
									pData->rdh.rcBound.bottom = y+1;
								pData->rdh.nCount++;

								// On Windows98, ExtCreateRegion() may fail if the number of rectangles is too
								// large (ie: > 4000). Therefore, we have to create the region by multiple steps.
								if (pData->rdh.nCount == 2000) {
									HRGN h = ExtCreateRegion(NULL, sizeof(RGNDATAHEADER) + (sizeof(RECT) * maxRects), pData);
									if (hRgn) {
										CombineRgn(hRgn, hRgn, h, RGN_OR);
										DeleteObject(h);
									}
									else
										hRgn = h;
									pData->rdh.nCount = 0;
									SetRect(&pData->rdh.rcBound, MAXLONG, MAXLONG, 0, 0);
								}
							}
						}

						// Go to next row (remember, the bitmap is inverted vertically)
						p32 -= bm32.bmWidthBytes;
					}

					// Create or extend the region with the remaining rectangles
					HRGN h = ExtCreateRegion(NULL, sizeof(RGNDATAHEADER) + (sizeof(RECT) * maxRects), pData);
					if (hRgn) {
						CombineRgn(hRgn, hRgn, h, RGN_OR);
						DeleteObject(h);
					}
					else
						hRgn = h;

					// Clean up
					GlobalFree(hData);
					SelectObject(hDC, holdBmp);
					DeleteDC(hDC);
				}

				DeleteObject(SelectObject(hMemDC, holdBmp));
			}

			DeleteDC(hMemDC);
		}	
	}

	return hRgn;
}

void
MyTransparentBlt(
	HDC hdcDest,
	int nXDest,
	int nYDest,
	int nWidth, 
	int nHeight,
	HBITMAP hBitmap,
	int nXSrc,
	int nYSrc,
	COLORREF colorTransparent,
	HPALETTE hPal)
{
	HDC dc, memDC, maskDC, tempDC;
	dc =  hdcDest;
	maskDC = CreateCompatibleDC(dc);
	memDC = CreateCompatibleDC(dc);
	tempDC = CreateCompatibleDC(dc);
	
	//add these to store return of SelectObject() calls
	HBITMAP pOldMemBmp;
	HBITMAP pOldMaskBmp;
	HBITMAP hOldTempBmp;
	HBITMAP maskBitmap;
	
	HBITMAP bmpImage = CreateCompatibleBitmap( dc, nWidth, nHeight );
	pOldMemBmp = (HBITMAP)SelectObject( memDC, bmpImage );
	
	// Select and realize the palette
	if( GetDeviceCaps(dc, RASTERCAPS) & RC_PALETTE && hPal ) {
		SelectPalette( dc, hPal, FALSE );
		RealizePalette(dc);
		SelectPalette( memDC, hPal, FALSE );
	}
	
	hOldTempBmp = (HBITMAP)SelectObject( tempDC, hBitmap );
	BitBlt( memDC, 0, 0, nWidth, nHeight, tempDC, nXSrc, nYSrc, SRCCOPY );
	
	// Create monochrome bitmap for the mask
	maskBitmap = CreateBitmap( nWidth, nHeight, 1, 1, NULL );
	pOldMaskBmp = (HBITMAP)SelectObject( maskDC, maskBitmap );
	SetBkColor( memDC, colorTransparent );
	
	// Create the mask from the memory DC
	BitBlt( maskDC, 0, 0, nWidth, nHeight, memDC, 0, 0, SRCCOPY );
	
	// Set the background in memDC to black. Using SRCPAINT with black 
	// and any other color results in the other color, thus making 
	// black the transparent color
	SetBkColor( memDC, RGB(0,0,0));
	SetTextColor( memDC, RGB(255,255,255));
	BitBlt( memDC, 0, 0, nWidth, nHeight, maskDC, 0, 0, SRCAND);
	
	// Set the foreground to black. See comment above.
	SetBkColor( dc, RGB(255,255,255));
	SetTextColor(dc, RGB(0,0,0));
	BitBlt( dc, nXDest, nYDest, nWidth, nHeight, maskDC, 0, 0, SRCAND);
	
	// Combine the foreground with the background
	BitBlt( dc, nXDest, nYDest, nWidth, nHeight, memDC, 0, 0, SRCPAINT);
	
	SelectObject( tempDC, hOldTempBmp);
	SelectObject( maskDC, pOldMaskBmp );
	SelectObject( memDC, pOldMemBmp );

	DeleteObject(memDC);
	DeleteObject(maskDC);
	DeleteObject(tempDC);

	DeleteObject(maskBitmap);
	DeleteObject(bmpImage);
	DeleteObject(hOldTempBmp);
	DeleteObject(pOldMaskBmp);
	DeleteObject(pOldMemBmp);
}

bool
TransparentBltA(
	HDC dcDest,         // handle to Dest DC
	int nXOriginDest,   // x-coord of destination upper-left corner
    int nYOriginDest,   // y-coord of destination upper-left corner
    int nWidthDest,     // width of destination rectangle
    int nHeightDest,    // height of destination rectangle
    HDC dcSrc,          // handle to source DC
    int nXOriginSrc,    // x-coord of source upper-left corner
    int nYOriginSrc,    // y-coord of source upper-left corner
    int nWidthSrc,      // width of source rectangle
    int nHeightSrc,     // height of source rectangle
    UINT crTransparent) // color to make transparent
{
     if (nWidthDest  < 1) return FALSE;
     if (nWidthSrc   < 1) return FALSE;
     if (nHeightDest < 1) return FALSE;
     if (nHeightSrc  < 1) return FALSE;

     HDC dc = CreateCompatibleDC(NULL);
     HBITMAP bitmap = CreateBitmap(nWidthSrc, nHeightSrc, 1,
		 GetDeviceCaps(dc, BITSPIXEL), NULL);

     if (bitmap == NULL) {
         DeleteDC(dc);    
         return FALSE;
     }

     HBITMAP oldBitmap = (HBITMAP)SelectObject(dc, bitmap);

     if (!BitBlt(dc, 0, 0, nWidthSrc, nHeightSrc, dcSrc, nXOriginSrc,
		 nYOriginSrc, SRCCOPY)) {
         SelectObject(dc, oldBitmap); 
         DeleteObject(bitmap);        
         DeleteDC(dc);                
         return FALSE;
     }

     HDC maskDC = CreateCompatibleDC(NULL);
     HBITMAP maskBitmap = CreateBitmap(nWidthSrc, nHeightSrc, 1, 1, NULL);

     if (maskBitmap == NULL) {
         SelectObject(dc, oldBitmap); 
         DeleteObject(bitmap);        
         DeleteDC(dc);                
         DeleteDC(maskDC);            
         return FALSE;
     }

     HBITMAP oldMask =  (HBITMAP)SelectObject(maskDC, maskBitmap);

     SetBkColor(maskDC, RGB(0,0,0));
     SetTextColor(maskDC, RGB(255,255,255));
     if (!BitBlt(maskDC, 0,0,nWidthSrc,nHeightSrc,NULL,0,0,BLACKNESS)) {
         SelectObject(maskDC, oldMask); 
         DeleteObject(maskBitmap);      
         DeleteDC(maskDC);              
         SelectObject(dc, oldBitmap);   
         DeleteObject(bitmap);          
         DeleteDC(dc);                  
         return FALSE;
     }

     SetBkColor(dc, crTransparent);
     BitBlt(maskDC, 0,0,nWidthSrc,nHeightSrc,dc,0,0,SRCINVERT);

     SetBkColor(dc, RGB(0,0,0));
     SetTextColor(dc, RGB(255,255,255));
     BitBlt(dc, 0,0,nWidthSrc,nHeightSrc,maskDC,0,0,SRCAND);

     HDC newMaskDC = CreateCompatibleDC(NULL);
     HBITMAP newMask;
     newMask = CreateBitmap(nWidthDest, nHeightDest, 1, 
		 GetDeviceCaps(newMaskDC, BITSPIXEL), NULL);

     if (newMask == NULL) {
         SelectObject(dc, oldBitmap);
         DeleteDC(dc);
         SelectObject(maskDC, oldMask);
         DeleteDC(maskDC);
          DeleteDC(newMaskDC);
         DeleteObject(bitmap);     
         DeleteObject(maskBitmap); 
         return FALSE;
     }

     SetStretchBltMode(newMaskDC, COLORONCOLOR);
     HBITMAP oldNewMask = (HBITMAP) SelectObject(newMaskDC, newMask);
     StretchBlt(newMaskDC, 0, 0, nWidthDest, nHeightDest, maskDC, 0, 0,
		 nWidthSrc, nHeightSrc, SRCCOPY);

     SelectObject(maskDC, oldMask);
     DeleteDC(maskDC);
     DeleteObject(maskBitmap); 

     HDC newImageDC = CreateCompatibleDC(NULL);
     HBITMAP newImage = CreateBitmap(nWidthDest, nHeightDest, 1,
		 GetDeviceCaps(newMaskDC, BITSPIXEL), NULL);

     if (newImage == NULL) {
         SelectObject(dc, oldBitmap);
         DeleteDC(dc);
         DeleteDC(newMaskDC);
         DeleteObject(bitmap);     
         return FALSE;
     }

     HBITMAP oldNewImage = (HBITMAP)SelectObject(newImageDC, newImage);
     StretchBlt(newImageDC, 0, 0, nWidthDest, nHeightDest, dc, 0, 0, nWidthSrc,
		 nHeightSrc, SRCCOPY);

     SelectObject(dc, oldBitmap);
     DeleteDC(dc);
     DeleteObject(bitmap);     

     BitBlt( dcDest, nXOriginDest, nYOriginDest, nWidthDest, nHeightDest, 
		 newMaskDC, 0, 0, SRCAND);

     BitBlt( dcDest, nXOriginDest, nYOriginDest, nWidthDest, nHeightDest,
		 newImageDC, 0, 0, SRCPAINT);

     SelectObject(newImageDC, oldNewImage);
     DeleteDC(newImageDC);
     SelectObject(newMaskDC, oldNewMask);
     DeleteDC(newMaskDC);
     DeleteObject(newImage);   
     DeleteObject(newMask);    

     return TRUE;
}

void
TransparentBltB(
	HDC hdcDest,		// handle to Dest DC
	int nXOriginDest,   // x-coord of destination upper-left corner
	int nYOriginDest,   // y-coord of destination upper-left corner
	int nWidthDest,     // width of destination rectangle
	int nHeightDest,    // height of destination rectangle
	HDC hdcSrc,         // handle to source DC
	int nXOriginSrc,    // x-coord of source upper-left corner
	int nYOriginSrc,    // y-coord of source upper-left corner
	int nWidthSrc,      // width of source rectangle
	int nHeightSrc,     // height of source rectangle
	UINT crTransparent) // color to make transparent
{
	HBITMAP hOldImageBMP, hImageBMP;
	hImageBMP = CreateCompatibleBitmap(hdcDest, nWidthDest, nHeightDest); // create memory bitmap

	HBITMAP hOldMaskBMP, hMaskBMP;
	hMaskBMP = CreateBitmap(nWidthDest, nHeightDest, 1, 1, NULL); // create mask bitmap

	HDC hImageDC = CreateCompatibleDC(hdcDest);
	HDC hMaskDC  = CreateCompatibleDC(hdcDest);
	hOldImageBMP = (HBITMAP)SelectObject(hImageDC, hImageBMP);
	hOldMaskBMP  = (HBITMAP)SelectObject(hMaskDC, hMaskBMP);

	// copy bitmap in source DC to target DC
	if (nWidthDest == nWidthSrc && nHeightDest == nHeightSrc)
		BitBlt(hImageDC, 0, 0, nWidthDest, nHeightDest, hdcSrc, nXOriginSrc, nYOriginSrc, SRCCOPY);
	else
		StretchBlt(hImageDC, 0, 0, nWidthDest, nHeightDest, 
					hdcSrc, nXOriginSrc, nYOriginSrc, nWidthSrc, nHeightSrc, SRCCOPY);

	// set transparent color
	SetBkColor(hImageDC, crTransparent);
	BitBlt(hMaskDC, 0, 0, nWidthDest, nHeightDest, hImageDC, 0, 0, SRCCOPY);

	// set transparent color to white
	SetBkColor(hImageDC, RGB(0,0,0));
	SetTextColor(hImageDC, RGB(255,255,255));
	BitBlt(hImageDC, 0, 0, nWidthDest, nHeightDest, hMaskDC, 0, 0, SRCAND);

	// set transparent color to black
	SetBkColor(hdcDest,RGB(255,255,255));
	SetTextColor(hdcDest,RGB(0,0,0));
	BitBlt(hdcDest, nXOriginDest, nYOriginDest, nWidthDest, nHeightDest, hMaskDC, 0, 0, SRCAND);
	BitBlt(hdcDest, nXOriginDest, nYOriginDest, nWidthDest, nHeightDest, hImageDC, 0, 0, SRCPAINT);

	// release memory
	SelectObject(hImageDC, hOldImageBMP);
	DeleteDC(hImageDC);
	SelectObject(hMaskDC, hOldMaskBMP);
	DeleteDC(hMaskDC);
	DeleteObject(hImageBMP);
	DeleteObject(hMaskBMP);
}
