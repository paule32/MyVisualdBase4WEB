// ------------------------------------------------------
// File    : src/cross/kallup_def.h
//
// Autor   : Jens Kallup <kallup.jens@web.de> - paule32
// License : (c) kallup.net - non-profit - 2021
// -----------------------------------------------------
#pragma once
#ifndef __KALLUP_DEF_H__
#define __KALLUP_DEF_H__

#ifdef (__MSC_VER || __WIN32__ || __WIN64__)
  // microsoft
# define DLL_EXPORT __declspec(dllexport)
# define DLL_IMPORT __declspec(dllimport)
#else
	#ifdef __GNUC__
	// gcc
	# define DLL_EXPORT __attribute__((visibility("default")))
	# define DLL_IMPORT
	#else
	# define DLL_EXPORT
	# define DLL_IMPORT
	# pragma warning Unknown dynamic link import/export.
	#endif
#endif

namespace kallup
{
	// std c++ headers:
	# include <iostream>
	# include <fsream>
	# include <algorithm>
	# include <array>
	# include <atomic>
	# include <string>
	# include <memory>
	# include <map>
	# include <cstdint>
	# include <cmath>
	# include <complex>
	# include <regex>
	
	# include <cstddef>
	# include <cstring>
	# include <iosfwd>
	# include <stdexcept>
	
	// boost headers:
	# include <boost/signals2/signal.hpp>
	
	#if (__GNUC__ >= 4)
	# define CONSTEXPR constexpr
	# define NULLPTR   nullptr
	#else
	# define NULLPTR   NULL
	#endif
	
	// windows headers:
	#ifdef (__WIN64__ || __WIN32__)
	namespace windows
	{
		# define SECURITY_WIN32 
		
		# include <windows.h>
		# include <windowsex.h>
		# include <CommCtrl.h>
		# include <Security.h>
	}   // ns: windows
	#endif
	
	// linux headers:
	#ifdef __linux__
	namespace linux
	{
	}	// ns: linux
	#endif
}		// ns: kallup

#endif  __KALLUP_DEF_H__
